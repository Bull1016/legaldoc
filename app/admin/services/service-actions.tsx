// app/admin/services/service-actions.tsx
"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import { ToggleLeft, ToggleRight, Trash2, Loader2 } from "lucide-react";

export function AdminServiceActions({ serviceId, isActive }: { serviceId: string; isActive: boolean }) {
  const router = useRouter();
  const [loading, setLoading] = useState<string | null>(null);

  async function toggleActive() {
    setLoading("toggle");
    await fetch(`/api/services/${serviceId}`, {
      method: "PATCH",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ active: !isActive }),
    });
    setLoading(null);
    router.refresh();
  }

  async function deleteService() {
    if (!confirm("Supprimer ce service ? Si des demandes existent, il sera désactivé.")) return;
    setLoading("delete");
    await fetch(`/api/services/${serviceId}`, { method: "DELETE" });
    setLoading(null);
    router.refresh();
  }

  return (
    <div className="flex items-center gap-2">
      <button
        onClick={toggleActive}
        disabled={loading !== null}
        title={isActive ? "Désactiver" : "Activer"}
        className="p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-500 hover:text-primary"
      >
        {loading === "toggle" ? (
          <Loader2 className="h-4 w-4 animate-spin" />
        ) : isActive ? (
          <ToggleRight className="h-5 w-5 text-secondary" />
        ) : (
          <ToggleLeft className="h-5 w-5" />
        )}
      </button>
      <button
        onClick={deleteService}
        disabled={loading !== null}
        title="Supprimer"
        className="p-1.5 rounded-lg hover:bg-red-50 transition-colors text-gray-400 hover:text-red-500"
      >
        {loading === "delete" ? (
          <Loader2 className="h-4 w-4 animate-spin" />
        ) : (
          <Trash2 className="h-4 w-4" />
        )}
      </button>
    </div>
  );
}