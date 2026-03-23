// app/api/upload/route.ts
import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { createServiceClient, STORAGE_BUCKET } from "@/lib/supabase";
import { MAX_FILE_SIZE, ALLOWED_FILE_TYPES } from "@/lib/utils";

export async function POST(req: NextRequest) {
  try {
    const session = await getServerSession(authOptions);
    if (!session) {
      return NextResponse.json({ error: "Non authentifié" }, { status: 401 });
    }

    const formData = await req.formData();
    const file = formData.get("file") as File | null;
    const requestId = formData.get("requestId") as string | null;

    if (!file) {
      return NextResponse.json({ error: "Aucun fichier fourni" }, { status: 400 });
    }

    // Valider la taille
    if (file.size > MAX_FILE_SIZE) {
      return NextResponse.json(
        { error: "Le fichier dépasse la limite de 10 Mo" },
        { status: 400 }
      );
    }

    // Valider le type
    if (!ALLOWED_FILE_TYPES.includes(file.type)) {
      return NextResponse.json(
        { error: "Format non autorisé. Utilisez PDF, JPG ou PNG." },
        { status: 400 }
      );
    }

    const supabase = createServiceClient();

    // Construire le chemin : userId/requestId/timestamp_filename
    const ext = file.name.split(".").pop();
    const safeName = file.name
      .replace(/[^a-zA-Z0-9.-]/g, "_")
      .toLowerCase();
    const path = `${session.user.id}/${requestId || "tmp"}/${Date.now()}_${safeName}`;

    const bytes = await file.arrayBuffer();
    const buffer = Buffer.from(bytes);

    const { data, error } = await supabase.storage
      .from(STORAGE_BUCKET)
      .upload(path, buffer, {
        contentType: file.type,
        upsert: false,
      });

    if (error) {
      console.error("[UPLOAD_SUPABASE]", error);
      return NextResponse.json(
        { error: "Erreur lors de l'upload du fichier" },
        { status: 500 }
      );
    }

    const { data: urlData } = supabase.storage
      .from(STORAGE_BUCKET)
      .getPublicUrl(data.path);

    return NextResponse.json({
      url: urlData.publicUrl,
      path: data.path,
      name: file.name,
      size: file.size,
      type: file.type,
    });
  } catch (error) {
    console.error("[UPLOAD]", error);
    return NextResponse.json({ error: "Erreur serveur lors de l'upload" }, { status: 500 });
  }
}