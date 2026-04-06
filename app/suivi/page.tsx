// app/suivi/page.tsx
"use client";

import { useState } from "react";
import { Navbar } from "@/components/navbar";
import { Footer } from "@/components/footer";
import { StatusBadge } from "@/components/status-badge";
import { Search, AlertCircle, CheckCircle2, Calendar, Tag, Loader2, FileDown } from "lucide-react";
import { formatDate } from "@/lib/utils";
import { RequestStatus } from "@prisma/client";

interface TrackResult {
  uniqueCode: string;
  status: RequestStatus;
  createdAt: string;
  updatedAt: string;
  finalDocumentUrl: string | null;
  refusalReason: string | null;
  service: { name: string; category: string | null };
}

export default function SuiviPage() {
  const [code, setCode] = useState("");
  const [loading, setLoading] = useState(false);
  const [result, setResult] = useState<TrackResult | null>(null);
  const [error, setError] = useState("");

  async function handleSearch(e: React.FormEvent) {
    e.preventDefault();
    if (!code.trim()) return;
    setLoading(true);
    setError("");
    setResult(null);

    try {
      const res = await fetch(`/api/track/${code.trim().toUpperCase()}`);
      const data = await res.json();
      if (res.ok) {
        setResult(data.request);
      } else {
        setError(data.error || "Dossier introuvable.");
      }
    } catch {
      setError("Erreur réseau. Veuillez réessayer.");
    } finally {
      setLoading(false);
    }
  }

  const TIMELINE = [
    { status: "submitted", label: "Demande soumise" },
    { status: "assigned", label: "Prise en charge" },
    { status: "in_review", label: "En cours d'examen" },
    { status: "completed", label: "Terminée" },
  ];

  const statusOrder = ["submitted", "assigned", "in_review", "completed"];
  const currentIdx = result ? statusOrder.indexOf(result.status) : -1;
  const isRefused = result?.status === "refused";

  return (
    <div className="min-h-screen">
      <Navbar />

      <main className="pb-20">
        {/* Header */}
        <div className="bg-white border-b border-gray-100 py-12">
          <div className="mx-auto max-w-3xl px-4 sm:px-6 text-center">
            <div className="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 mb-4 mx-auto">
              <Search className="h-7 w-7 text-primary" />
            </div>
            <h1 className="section-title">Suivre ma demande</h1>
            <p className="section-subtitle max-w-xl mx-auto">
              Entrez votre code unique reçu par email pour consulter l'état de votre dossier.
            </p>
          </div>
        </div>

        {/* Search box */}
        <div className="mx-auto max-w-2xl px-4 sm:px-6 py-10">
          <form onSubmit={handleSearch} className="card">
            <label className="label text-base font-semibold">Code de suivi</label>
            <p className="text-sm text-gray-400 mb-4">Format : <code className="bg-gray-100 px-1.5 py-0.5 rounded text-primary font-mono">LD-2026-XXXXXXXX</code></p>
            <div className="flex gap-3">
              <input
                type="text"
                value={code}
                onChange={(e) => setCode(e.target.value.toUpperCase())}
                placeholder="LD-2026-XXXXXXXX"
                className="input-field flex-1 font-mono tracking-widest uppercase"
                maxLength={18}
              />
              <button type="submit" disabled={loading || !code.trim()} className="btn-primary shrink-0">
                {loading ? <Loader2 className="h-4 w-4 animate-spin" /> : <Search className="h-4 w-4" />}
                Rechercher
              </button>
            </div>

            {error && (
              <div className="flex items-center gap-2 mt-4 rounded-xl bg-red-50 border border-red-100 p-3.5 text-sm text-red-600">
                <AlertCircle className="h-4 w-4 shrink-0" />
                {error}
              </div>
            )}
          </form>

          {/* Result */}
          {result && (
            <div className="mt-6 card animate-slide-up">
              <div className="flex items-start justify-between mb-6">
                <div>
                  <p className="text-xs text-gray-400 mb-1">Référence dossier</p>
                  <p className="font-mono font-bold text-lg text-primary tracking-wide">{result.uniqueCode}</p>
                </div>
                <StatusBadge status={result.status} />
              </div>

              <div className="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-xl">
                <div>
                  <p className="text-xs text-gray-400 flex items-center gap-1 mb-1"><Tag className="h-3 w-3" />Service</p>
                  <p className="text-sm font-semibold text-[#111]">{result.service.name}</p>
                </div>
                <div>
                  <p className="text-xs text-gray-400 flex items-center gap-1 mb-1"><Calendar className="h-3 w-3" />Soumis le</p>
                  <p className="text-sm font-semibold text-[#111]">{formatDate(result.createdAt)}</p>
                </div>
                <div>
                  <p className="text-xs text-gray-400 mb-1">Dernière mise à jour</p>
                  <p className="text-sm font-semibold text-[#111]">{formatDate(result.updatedAt)}</p>
                </div>
              </div>

              {/* Timeline */}
              {!isRefused ? (
                <div className="mb-6">
                  <p className="text-sm font-semibold text-[#111] mb-4">Progression du dossier</p>
                  <div className="flex items-center gap-0">
                    {TIMELINE.map((step, i) => {
                      const isDone = i <= currentIdx;
                      const isCurrent = i === currentIdx;
                      return (
                        <div key={step.status} className="flex items-center flex-1">
                          <div className="flex flex-col items-center">
                            <div className={`flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold transition-all
                              ${isDone ? "bg-secondary text-white" : "bg-gray-200 text-gray-400"}
                              ${isCurrent ? "ring-4 ring-secondary/20" : ""}`}>
                              {isDone ? <CheckCircle2 className="h-4 w-4" /> : i + 1}
                            </div>
                            <span className={`mt-1.5 text-xs text-center max-w-[60px] font-medium
                              ${isDone ? "text-secondary" : "text-gray-400"}`}>
                              {step.label}
                            </span>
                          </div>
                          {i < TIMELINE.length - 1 && (
                            <div className={`h-0.5 flex-1 mb-4 ${i < currentIdx ? "bg-secondary" : "bg-gray-200"}`} />
                          )}
                        </div>
                      );
                    })}
                  </div>
                </div>
              ) : (
                <div className="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                  <p className="text-sm font-semibold text-red-700 mb-1">Demande refusée</p>
                  {result.refusalReason && (
                    <p className="text-sm text-red-600">Motif : {result.refusalReason}</p>
                  )}
                </div>
              )}

              {result.finalDocumentUrl === "AVAILABLE" && (
                <div className="flex items-center gap-3 p-4 bg-green-50 border border-green-100 rounded-xl">
                  <CheckCircle2 className="h-5 w-5 text-secondary shrink-0" />
                  <div>
                    <p className="text-sm font-semibold text-green-700">Document disponible</p>
                    <p className="text-xs text-green-600">Connectez-vous à votre espace client pour télécharger le document final.</p>
                  </div>
                </div>
              )}
            </div>
          )}
        </div>

        {/* Help box */}
        <div className="mx-auto max-w-2xl px-4 sm:px-6">
          <div className="rounded-2xl border border-gray-200 bg-white p-6">
            <h3 className="font-display font-semibold text-[#111] mb-3">Où trouver mon code ?</h3>
            <ul className="space-y-2 text-sm text-gray-500">
              <li className="flex items-start gap-2"><CheckCircle2 className="h-4 w-4 text-secondary mt-0.5 shrink-0" />Dans l'email de confirmation reçu après votre soumission</li>
              <li className="flex items-start gap-2"><CheckCircle2 className="h-4 w-4 text-secondary mt-0.5 shrink-0" />Dans votre tableau de bord si vous avez un compte</li>
              <li className="flex items-start gap-2"><CheckCircle2 className="h-4 w-4 text-secondary mt-0.5 shrink-0" />Format : LD-ANNÉE-8CARACTÈRES (ex: LD-2026-AB12CD34)</li>
            </ul>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  );
}