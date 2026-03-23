// app/api/services/route.ts
import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/db";

export async function GET(req: NextRequest) {
  try {
    const { searchParams } = new URL(req.url);
    const category = searchParams.get("category");
    const search = searchParams.get("search");
    const activeOnly = searchParams.get("activeOnly") !== "false";

    const services = await prisma.service.findMany({
      where: {
        ...(activeOnly && { active: true }),
        ...(category && { category }),
        ...(search && {
          OR: [
            { name: { contains: search, mode: "insensitive" } },
            { description: { contains: search, mode: "insensitive" } },
          ],
        }),
      },
      include: { _count: { select: { requests: true } } },
      orderBy: { createdAt: "asc" },
    });

    return NextResponse.json({ services });
  } catch (error) {
    console.error("[SERVICES_GET]", error);
    return NextResponse.json({ error: "Erreur serveur" }, { status: 500 });
  }
}

export async function POST(req: NextRequest) {
  try {
    const session = await getServerSession(authOptions);
    if (!session || session.user.role !== "admin") {
      return NextResponse.json({ error: "Non autorisé" }, { status: 403 });
    }

    const body = await req.json();
    const { name, description, category, basePrice, formSchema, requiredRole, icon } = body;

    if (!name || !description || !formSchema || !requiredRole) {
      return NextResponse.json({ error: "Champs obligatoires manquants" }, { status: 400 });
    }

    const service = await prisma.service.create({
      data: {
        name,
        description,
        category: category || null,
        basePrice: basePrice ? parseFloat(basePrice) : null,
        formSchema,
        requiredRole,
        icon: icon || null,
        active: true,
      },
    });

    return NextResponse.json({ service }, { status: 201 });
  } catch (error) {
    console.error("[SERVICES_POST]", error);
    return NextResponse.json({ error: "Erreur lors de la création du service" }, { status: 500 });
  }
}