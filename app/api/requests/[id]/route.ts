// app/api/requests/[id]/route.ts
import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/db";

export async function GET(_req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const session = await getServerSession(authOptions);
    if (!session) {
      return NextResponse.json({ error: "Non authentifié" }, { status: 401 });
    }

    const request = await prisma.request.findUnique({
      where: { id: params.id },
      include: {
        user: { select: { id: true, fullName: true, email: true, phone: true } },
        service: { select: { id: true, name: true, category: true, requiredRole: true, formSchema: true } },
        assignedUser: { select: { id: true, fullName: true, email: true } },
        notifications: { orderBy: { sentAt: "desc" }, take: 5 },
      },
    });

    if (!request) {
      return NextResponse.json({ error: "Demande introuvable" }, { status: 404 });
    }

    const role = session.user.role;
    const userId = session.user.id;

    // Vérifier les permissions
    if (role === "client" && request.userId !== userId) {
      return NextResponse.json({ error: "Accès refusé" }, { status: 403 });
    }

    return NextResponse.json({ request });
  } catch (error) {
    console.error("[REQUEST_GET]", error);
    return NextResponse.json({ error: "Erreur serveur" }, { status: 500 });
  }
}

export async function PATCH(req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const session = await getServerSession(authOptions);
    if (!session) {
      return NextResponse.json({ error: "Non authentifié" }, { status: 401 });
    }

    const role = session.user.role;
    if (role === "client") {
      return NextResponse.json({ error: "Non autorisé" }, { status: 403 });
    }

    const body = await req.json();
    const { status, assignedTo, finalDocumentUrl, notesInternal, refusalReason } = body;

    const existing = await prisma.request.findUnique({ where: { id: params.id } });
    if (!existing) {
      return NextResponse.json({ error: "Demande introuvable" }, { status: 404 });
    }

    // Juriste/expert ne peut modifier que les demandes qui lui sont assignées ou de son domaine
    if (role !== "admin") {
      const isAssigned = existing.assignedTo === session.user.id;
      if (!isAssigned && status !== "assigned") {
        return NextResponse.json({ error: "Accès refusé à cette demande" }, { status: 403 });
      }
    }

    const updated = await prisma.request.update({
      where: { id: params.id },
      data: {
        ...(status && { status }),
        ...(assignedTo !== undefined && { assignedTo }),
        ...(finalDocumentUrl !== undefined && { finalDocumentUrl }),
        ...(notesInternal !== undefined && { notesInternal }),
        ...(refusalReason !== undefined && { refusalReason }),
        // Assigner automatiquement au juriste qui prend en charge
        ...(status === "assigned" && !existing.assignedTo && {
          assignedTo: session.user.id,
        }),
      },
    });

    // Créer une notification selon le statut
    const statusMessages: Record<string, string> = {
      assigned: "Votre demande a été prise en charge par un expert.",
      in_review: "Votre demande est en cours d'examen par notre équipe.",
      completed: "Votre demande est terminée. Le document final est disponible.",
      refused: `Votre demande a été refusée. Motif : ${refusalReason || "Non précisé"}`,
    };

    if (status && statusMessages[status]) {
      await prisma.notification.create({
        data: {
          requestId: params.id,
          message: statusMessages[status],
          type: status === "refused" ? "error" : status === "completed" ? "success" : "info",
        },
      });
    }

    return NextResponse.json({ request: updated });
  } catch (error) {
    console.error("[REQUEST_PATCH]", error);
    return NextResponse.json({ error: "Erreur lors de la mise à jour" }, { status: 500 });
  }
}
