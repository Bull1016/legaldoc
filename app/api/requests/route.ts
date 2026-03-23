// app/api/requests/route.ts
import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/db";
import { generateUniqueCode } from "@/lib/utils";

export async function GET(req: NextRequest) {
  try {
    const session = await getServerSession(authOptions);
    if (!session) {
      return NextResponse.json({ error: "Non authentifié" }, { status: 401 });
    }

    const { searchParams } = new URL(req.url);
    const status = searchParams.get("status");
    const page = parseInt(searchParams.get("page") || "1");
    const limit = parseInt(searchParams.get("limit") || "20");
    const skip = (page - 1) * limit;

    const role = session.user.role;
    const userId = session.user.id;

    // Construire le filtre selon le rôle
    let where: Record<string, unknown> = {};

    if (role === "client") {
      where = { userId };
    } else if (role === "juriste" || role === "expert_compta") {
      where = {
        OR: [
          { assignedTo: userId },
          { service: { requiredRole: role === "juriste" ? "juriste" : "expert_compta" } },
        ],
      };
    }
    // admin voit tout → where reste vide

    if (status) {
      where.status = status;
    }

    const [requests, total] = await Promise.all([
      prisma.request.findMany({
        where,
        include: {
          user: { select: { id: true, fullName: true, email: true, phone: true } },
          service: { select: { id: true, name: true, category: true, requiredRole: true } },
          assignedUser: { select: { id: true, fullName: true, email: true } },
        },
        orderBy: { updatedAt: "desc" },
        skip,
        take: limit,
      }),
      prisma.request.count({ where }),
    ]);

    return NextResponse.json({ requests, total, page, limit });
  } catch (error) {
    console.error("[REQUESTS_GET]", error);
    return NextResponse.json({ error: "Erreur serveur" }, { status: 500 });
  }
}

export async function POST(req: NextRequest) {
  try {
    const session = await getServerSession(authOptions);
    if (!session) {
      return NextResponse.json({ error: "Non authentifié" }, { status: 401 });
    }

    const body = await req.json();
    const { serviceId, formData, documentsUploaded } = body;

    if (!serviceId || !formData) {
      return NextResponse.json({ error: "Données incomplètes" }, { status: 400 });
    }

    // Vérifier que le service existe et est actif
    const service = await prisma.service.findUnique({ where: { id: serviceId, active: true } });
    if (!service) {
      return NextResponse.json({ error: "Service introuvable ou inactif" }, { status: 404 });
    }

    // Générer un code unique (avec retry en cas de collision)
    let uniqueCode = generateUniqueCode();
    let attempts = 0;
    while (attempts < 5) {
      const existing = await prisma.request.findUnique({ where: { uniqueCode } });
      if (!existing) break;
      uniqueCode = generateUniqueCode();
      attempts++;
    }

    const request = await prisma.request.create({
      data: {
        uniqueCode,
        userId: session.user.id,
        serviceId,
        status: "submitted",
        formData,
        documentsUploaded: documentsUploaded || [],
      },
      include: {
        service: { select: { name: true } },
      },
    });

    // Créer une notification
    await prisma.notification.create({
      data: {
        requestId: request.id,
        message: `Votre demande "${request.service.name}" a été soumise avec succès. Code de suivi : ${uniqueCode}`,
        type: "success",
      },
    });

    return NextResponse.json({ request }, { status: 201 });
  } catch (error) {
    console.error("[REQUESTS_POST]", error);
    return NextResponse.json({ error: "Erreur lors de la soumission" }, { status: 500 });
  }
}