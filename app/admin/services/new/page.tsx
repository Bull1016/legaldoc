// app/admin/services/new/page.tsx
"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import { ArrowLeft, PlusCircle, Trash2, Loader2, AlertCircle } from "lucide-react";
import Link from "next/link";

const ICONS_LIST = ["Building2", "FileText", "Shield", "Rocket", "Edit", "Scale", "Landmark", "Briefcase", "FileCheck"];
const CATEGORIES = ["Entreprise", "Contrats", "Protection", "Formalites"];
const ROLES = [
  { value: "juriste", label: "Juriste" },
  { value: "expert_compta", label: "Expert-comptable" },
  { value: "admin", label: "Administrateur" },
];

export default function NewServicePage() {
  const router = useRouter();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  const [form, setForm] = useState({
    name: "",
    description: "",
    category: "Entreprise",
    basePrice: "",
    icon: "Scale",
    requiredRole: "juriste",
  });

  const [steps, setSteps] = useState([
    { title: "Informations", fields: [{ id: "field_1", label: "", type: "text", required: true, placeholder: "" }] },
  ]);

  const [requiredDocs, setRequiredDocs] = useState([""]);

  function addStep() {
    setSteps((prev) => [...prev, { title: `Étape ${prev.length + 1}`, fields: [{ id: `field_${Date.now()}`, label: "", type: "text", required: true, placeholder: "" }] }]);
  }

  function addField(stepIdx: number) {
    setSteps((prev) => {
      const next = [...prev];
      next[stepIdx] = {
        ...next[stepIdx],
        fields: [...next[stepIdx].fields, { id: `field_${Date.now()}`, label: "", type: "text", required: false, placeholder: "" }],
      };
      return next;
    });
  }

  function removeField(stepIdx: number, fieldIdx: number) {
    setSteps((prev) => {
      const next = [...prev];
      next[stepIdx] = { ...next[stepIdx], fields: next[stepIdx].fields.filter((_, i) => i !== fieldIdx) };
      return next;
    });
  }

  function updateField(stepIdx: number, fieldIdx: number, key: string, value: string | boolean) {
    setSteps((prev) => {
      const next = [...prev];
      const fields = [...next[stepIdx].fields];
      fields[fieldIdx] = { ...fields[fieldIdx], [key]: value };
      next[stepIdx] = { ...next[stepIdx], fields };
      return next;
    });
  }

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const res = await fetch("/api/services", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          ...form,
          basePrice: form.basePrice ? parseFloat(form.basePrice) : null,
          formSchema: {
            steps,
            requiredDocuments: requiredDocs.filter((d) => d.trim()),
          },
        }),
      });
      const data = await res.json();
      if (res.ok) {
        router.push("/admin/services");
      } else {
        setError(data.error || "Erreur lors de la création");
      }
    } catch {
      setError("Erreur réseau");
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="max-w-3xl mx-auto animate-fade-in">
      <div className="mb-6">
        <Link href="/admin/services" className="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-primary transition-colors mb-4">
          <ArrowLeft className="h-4 w-4" />Retour aux services
        </Link>
        <h1 className="font-display text-2xl font-bold text-[#111]">Nouveau service</h1>
      </div>

      <form onSubmit={handleSubmit} className="space-y-6">
        {/* Basic info */}
        <div className="card space-y-4">
          <h2 className="font-display font-semibold text-[#111]">Informations générales</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div className="sm:col-span-2">
              <label className="label">Nom du service *</label>
              <input type="text" value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })}
                placeholder="Ex: Création de SARL" required className="input-field" />
            </div>
            <div className="sm:col-span-2">
              <label className="label">Description *</label>
              <textarea value={form.description} onChange={(e) => setForm({ ...form, description: e.target.value })}
                placeholder="Décrivez le service en détail..." required rows={3} className="input-field" />
            </div>
            <div>
              <label className="label">Catégorie</label>
              <select value={form.category} onChange={(e) => setForm({ ...form, category: e.target.value })} className="input-field">
                {CATEGORIES.map((c) => <option key={c} value={c}>{c}</option>)}
              </select>
            </div>
            <div>
              <label className="label">Prix indicatif (€)</label>
              <input type="number" value={form.basePrice} onChange={(e) => setForm({ ...form, basePrice: e.target.value })}
                placeholder="299" min="0" step="0.01" className="input-field" />
            </div>
            <div>
              <label className="label">Icône</label>
              <select value={form.icon} onChange={(e) => setForm({ ...form, icon: e.target.value })} className="input-field">
                {ICONS_LIST.map((i) => <option key={i} value={i}>{i}</option>)}
              </select>
            </div>
            <div>
              <label className="label">Rôle requis *</label>
              <select value={form.requiredRole} onChange={(e) => setForm({ ...form, requiredRole: e.target.value })} className="input-field">
                {ROLES.map((r) => <option key={r.value} value={r.value}>{r.label}</option>)}
              </select>
            </div>
          </div>
        </div>

        {/* Form steps */}
        <div className="card space-y-4">
          <div className="flex items-center justify-between">
            <h2 className="font-display font-semibold text-[#111]">Étapes du formulaire</h2>
            <button type="button" onClick={addStep} className="btn-ghost text-xs text-primary">
              <PlusCircle className="h-3.5 w-3.5" />Ajouter une étape
            </button>
          </div>

          {steps.map((step, si) => (
            <div key={si} className="border border-gray-200 rounded-xl p-4 space-y-3">
              <input type="text" value={step.title} onChange={(e) => setSteps((prev) => { const n = [...prev]; n[si] = { ...n[si], title: e.target.value }; return n; })}
                placeholder="Titre de l'étape" className="input-field font-semibold" />
              {step.fields.map((field, fi) => (
                <div key={field.id} className="grid grid-cols-2 sm:grid-cols-4 gap-2 items-end bg-gray-50 rounded-lg p-3">
                  <input type="text" value={field.label} onChange={(e) => updateField(si, fi, "label", e.target.value)}
                    placeholder="Label du champ" className="input-field text-xs" />
                  <select value={field.type} onChange={(e) => updateField(si, fi, "type", e.target.value)} className="input-field text-xs">
                    {["text", "textarea", "number", "date", "select", "email", "tel"].map((t) => <option key={t}>{t}</option>)}
                  </select>
                  <input type="text" value={field.placeholder || ""} onChange={(e) => updateField(si, fi, "placeholder", e.target.value)}
                    placeholder="Placeholder" className="input-field text-xs" />
                  <div className="flex items-center gap-2">
                    <label className="flex items-center gap-1 text-xs text-gray-500 cursor-pointer">
                      <input type="checkbox" checked={field.required} onChange={(e) => updateField(si, fi, "required", e.target.checked)} />
                      Requis
                    </label>
                    {step.fields.length > 1 && (
                      <button type="button" onClick={() => removeField(si, fi)} className="text-red-400 hover:text-red-600">
                        <Trash2 className="h-3.5 w-3.5" />
                      </button>
                    )}
                  </div>
                </div>
              ))}
              <button type="button" onClick={() => addField(si)} className="text-xs text-primary hover:underline flex items-center gap-1">
                <PlusCircle className="h-3 w-3" />Ajouter un champ
              </button>
            </div>
          ))}
        </div>

        {/* Required docs */}
        <div className="card space-y-3">
          <div className="flex items-center justify-between">
            <h2 className="font-display font-semibold text-[#111]">Documents requis</h2>
            <button type="button" onClick={() => setRequiredDocs((prev) => [...prev, ""])} className="btn-ghost text-xs text-primary">
              <PlusCircle className="h-3.5 w-3.5" />Ajouter
            </button>
          </div>
          {requiredDocs.map((doc, i) => (
            <div key={i} className="flex gap-2">
              <input type="text" value={doc} onChange={(e) => setRequiredDocs((prev) => { const n = [...prev]; n[i] = e.target.value; return n; })}
                placeholder="Ex: Pièce d'identité recto-verso" className="input-field flex-1 text-sm" />
              <button type="button" onClick={() => setRequiredDocs((prev) => prev.filter((_, j) => j !== i))} className="text-red-400 hover:text-red-600">
                <Trash2 className="h-4 w-4" />
              </button>
            </div>
          ))}
        </div>

        {error && (
          <div className="flex items-center gap-2 rounded-xl bg-red-50 border border-red-100 p-3.5 text-sm text-red-600">
            <AlertCircle className="h-4 w-4 shrink-0" />{error}
          </div>
        )}

        <div className="flex gap-3">
          <Link href="/admin/services" className="btn-secondary flex-1 justify-center">Annuler</Link>
          <button type="submit" disabled={loading} className="btn-primary flex-1 justify-center">
            {loading ? <><Loader2 className="h-4 w-4 animate-spin" />Création...</> : <><PlusCircle className="h-4 w-4" />Créer le service</>}
          </button>
        </div>
      </form>
    </div>
  );
}