// app/api/track/[code]/route.ts
import { NextRequest, NextResponse } from "next/server";
import prisma from "@/lib/db";

export async function GET(_req: NextRequest, { params }: { params: { code: string } }) {
  try {
    const request = await prisma.request.findUnique({
      where: { uniqueCode: params.code.toUpperCase() },
      select: {
        uniqueCode: true,
        status: true,
        createdAt: true,
        updatedAt: true,
        finalDocumentUrl: true,
        refusalReason: true,
        service: {
          select: { name: true, category: true },
        },
      },
    });

    if (!request) {
      return NextResponse.json(
        { error: "Code de suivi introuvable. Vérifiez votre code et réessayez." },
        { status: 404 }
      );
    }

    // Ne pas exposer finalDocumentUrl publiquement (nécessite connexion)
    return NextResponse.json({
      request: {
        ...request,
        finalDocumentUrl: request.finalDocumentUrl ? "AVAILABLE" : null,
      },
    });
  } catch (error) {
    console.error("[TRACK_GET]", error);
    return NextResponse.json({ error: "Erreur serveur" }, { status: 500 });
  }
}