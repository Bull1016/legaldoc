// app/api/services/[id]/route.ts
import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/db";

export async function GET(_req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const service = await prisma.service.findUnique({
      where: { id: params.id },
      include: { _count: { select: { requests: true } } },
    });

    if (!service) {
      return NextResponse.json({ error: "Service introuvable" }, { status: 404 });
    }

    return NextResponse.json({ service });
  } catch (error) {
    console.error("[SERVICE_GET]", error);
    return NextResponse.json({ error: "Erreur serveur" }, { status: 500 });
  }
}

export async function PATCH(req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const session = await getServerSession(authOptions);
    if (!session || session.user.role !== "admin") {
      return NextResponse.json({ error: "Non autorisé" }, { status: 403 });
    }

    const body = await req.json();
    const { name, description, category, basePrice, formSchema, requiredRole, active, icon } = body;

    const service = await prisma.service.update({
      where: { id: params.id },
      data: {
        ...(name !== undefined && { name }),
        ...(description !== undefined && { description }),
        ...(category !== undefined && { category }),
        ...(basePrice !== undefined && { basePrice: basePrice ? parseFloat(basePrice) : null }),
        ...(formSchema !== undefined && { formSchema }),
        ...(requiredRole !== undefined && { requiredRole }),
        ...(active !== undefined && { active }),
        ...(icon !== undefined && { icon }),
      },
    });

    return NextResponse.json({ service });
  } catch (error) {
    console.error("[SERVICE_PATCH]", error);
    return NextResponse.json({ error: "Erreur lors de la mise à jour" }, { status: 500 });
  }
}

export async function DELETE(_req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const session = await getServerSession(authOptions);
    if (!session || session.user.role !== "admin") {
      return NextResponse.json({ error: "Non autorisé" }, { status: 403 });
    }

    // Soft delete : désactiver plutôt que supprimer si des demandes existent
    const requestCount = await prisma.request.count({ where: { serviceId: params.id } });

    if (requestCount > 0) {
      await prisma.service.update({
        where: { id: params.id },
        data: { active: false },
      });
      return NextResponse.json({ message: "Service désactivé (des demandes existent)" });
    }

    await prisma.service.delete({ where: { id: params.id } });
    return NextResponse.json({ message: "Service supprimé" });
  } catch (error) {
    console.error("[SERVICE_DELETE]", error);
    return NextResponse.json({ error: "Erreur lors de la suppression" }, { status: 500 });
  }
}