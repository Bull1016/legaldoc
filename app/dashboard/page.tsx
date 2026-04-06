// app/dashboard/page.tsx
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/db";
import { StatusBadge } from "@/components/status-badge";
import { formatDate, formatDateTime } from "@/lib/utils";
import Link from "next/link";
import { PlusCircle, FileText, Search, ArrowRight, Clock, CheckCircle2, AlertCircle } from "lucide-react";
import { RequestStatus } from "@prisma/client";
import { Metadata } from "next";

export const metadata: Metadata = { title: "Mon espace client" };

export default async function DashboardPage({
  searchParams,
}: {
  searchParams: { code?: string; success?: string };
}) {
  const session = await getServerSession(authOptions);

  const requests = await prisma.request.findMany({
    where: { userId: session!.user.id },
    include: {
      service: { select: { name: true, category: true } },
    },
    orderBy: { updatedAt: "desc" },
  });

  const stats = {
    total: requests.length,
    inProgress: requests.filter((r) => ["submitted", "assigned", "in_review"].includes(r.status)).length,
    completed: requests.filter((r) => r.status === "completed").length,
    refused: requests.filter((r) => r.status === "refused").length,
  };

  return (
    <div className="max-w-5xl mx-auto animate-fade-in">
      {/* Success notification */}
      {searchParams.success && searchParams.code && (
        <div className="flex items-start gap-3 rounded-2xl bg-green-50 border border-green-200 p-5 mb-6">
          <CheckCircle2 className="h-5 w-5 text-secondary mt-0.5 shrink-0" />
          <div>
            <p className="font-semibold text-green-800">Demande soumise avec succès !</p>
            <p className="text-sm text-green-600 mt-0.5">
              Votre code de suivi :{" "}
              <code className="font-mono font-bold bg-green-100 px-2 py-0.5 rounded">
                {searchParams.code}
              </code>
              {" "}— Conservez-le précieusement.
            </p>
          </div>
        </div>
      )}

      {/* Header */}
      <div className="flex items-center justify-between mb-8">
        <div>
          <h1 className="font-display text-2xl font-bold text-[#111]">
            Bonjour, {session?.user.name?.split(" ")[0]} 👋
          </h1>
          <p className="text-gray-500 mt-1 text-sm">Suivez et gérez toutes vos demandes juridiques</p>
        </div>
        <Link href="/services" className="btn-primary">
          <PlusCircle className="h-4 w-4" />
          Nouvelle demande
        </Link>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        {[
          { label: "Total", value: stats.total, color: "text-primary", bg: "bg-primary/10" },
          { label: "En cours", value: stats.inProgress, color: "text-amber-600", bg: "bg-amber-50" },
          { label: "Terminées", value: stats.completed, color: "text-secondary", bg: "bg-secondary/10" },
          { label: "Refusées", value: stats.refused, color: "text-red-500", bg: "bg-red-50" },
        ].map((s) => (
          <div key={s.label} className="card text-center py-5">
            <p className={`font-display text-3xl font-extrabold ${s.color}`}>{s.value}</p>
            <p className="text-xs text-gray-500 mt-1">{s.label}</p>
          </div>
        ))}
      </div>

      {/* Quick actions */}
      <div className="flex gap-3 mb-8">
        <Link href="/suivi" className="flex-1 flex items-center gap-3 rounded-2xl border border-gray-200 bg-white p-4 hover:border-primary hover:shadow-sm transition-all group">
          <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 group-hover:bg-primary/20 transition-colors">
            <Search className="h-5 w-5 text-primary" />
          </div>
          <div>
            <p className="text-sm font-semibold text-[#111]">Suivi par code</p>
            <p className="text-xs text-gray-400">Accès public au dossier</p>
          </div>
          <ArrowRight className="h-4 w-4 text-gray-300 ml-auto group-hover:text-primary transition-colors" />
        </Link>
        <Link href="/services" className="flex-1 flex items-center gap-3 rounded-2xl border border-gray-200 bg-white p-4 hover:border-primary hover:shadow-sm transition-all group">
          <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-secondary/10 group-hover:bg-secondary/20 transition-colors">
            <PlusCircle className="h-5 w-5 text-secondary" />
          </div>
          <div>
            <p className="text-sm font-semibold text-[#111]">Nos services</p>
            <p className="text-xs text-gray-400">Démarrer une demande</p>
          </div>
          <ArrowRight className="h-4 w-4 text-gray-300 ml-auto group-hover:text-primary transition-colors" />
        </Link>
      </div>

      {/* Requests list */}
      <div>
        <h2 className="font-display text-lg font-bold text-[#111] mb-4">Mes demandes</h2>
        {requests.length === 0 ? (
          <div className="card text-center py-16">
            <FileText className="h-12 w-12 text-gray-200 mx-auto mb-4" />
            <h3 className="font-display font-semibold text-[#111] mb-2">Aucune demande</h3>
            <p className="text-sm text-gray-400 mb-6">Vous n'avez pas encore soumis de demande juridique.</p>
            <Link href="/services" className="btn-primary">
              <PlusCircle className="h-4 w-4" />
              Démarrer une demande
            </Link>
          </div>
        ) : (
          <div className="space-y-3">
            {requests.map((req) => (
              <div key={req.id} className="card hover:shadow-md transition-all">
                <div className="flex flex-col sm:flex-row sm:items-center gap-3">
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-2 mb-1 flex-wrap">
                      <code className="text-xs font-mono font-bold text-primary bg-primary/10 px-2 py-0.5 rounded">
                        {req.uniqueCode}
                      </code>
                      <StatusBadge status={req.status as RequestStatus} size="sm" />
                    </div>
                    <p className="font-semibold text-[#111] truncate">{req.service.name}</p>
                    <p className="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                      <Clock className="h-3 w-3" />
                      Mis à jour le {formatDateTime(req.updatedAt)}
                    </p>
                  </div>

                  <div className="flex items-center gap-3 shrink-0">
                    {req.status === "completed" && req.finalDocumentUrl && (
                      <a
                        href={req.finalDocumentUrl}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="btn-secondary text-xs px-3 py-2"
                      >
                        <FileText className="h-3.5 w-3.5" />
                        Télécharger
                      </a>
                    )}
                    {req.status === "refused" && (
                      <div className="flex items-center gap-1.5 text-xs text-red-500">
                        <AlertCircle className="h-3.5 w-3.5" />
                        {req.refusalReason ? `Motif : ${req.refusalReason}` : "Demande refusée"}
                      </div>
                    )}
                    <Link href={`/suivi?code=${req.uniqueCode}`} className="text-xs text-primary hover:underline font-medium">
                      Détails →
                    </Link>
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}