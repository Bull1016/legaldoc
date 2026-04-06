// app/(auth)/register/page.tsx
"use client";

import { useState } from "react";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { signIn } from "next-auth/react";
import { Eye, EyeOff, AlertCircle, CheckCircle2, Loader2, UserPlus } from "lucide-react";

export default function RegisterPage() {
  const router = useRouter();
  const [form, setForm] = useState({ fullName: "", email: "", phone: "", password: "", confirm: "" });
  const [showPassword, setShowPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  function handleChange(field: string, value: string) {
    setForm((prev) => ({ ...prev, [field]: value }));
  }

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError("");

    if (form.password !== form.confirm) {
      setError("Les mots de passe ne correspondent pas.");
      return;
    }
    if (form.password.length < 8) {
      setError("Le mot de passe doit contenir au moins 8 caractères.");
      return;
    }

    setLoading(true);
    try {
      const res = await fetch("/api/auth/register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ fullName: form.fullName, email: form.email, phone: form.phone, password: form.password }),
      });
      const data = await res.json();

      if (!res.ok) {
        setError(data.error || "Erreur lors de la création du compte.");
        return;
      }

      // Auto-login after register
      await signIn("credentials", { email: form.email, password: form.password, redirect: false });
      router.push("/dashboard");
    } catch {
      setError("Une erreur est survenue. Veuillez réessayer.");
    } finally {
      setLoading(false);
    }
  }

  const passwordStrength = form.password.length === 0 ? 0 : form.password.length < 8 ? 1 : form.password.length < 12 ? 2 : 3;
  const strengthColors = ["", "bg-red-400", "bg-amber-400", "bg-secondary"];
  const strengthLabels = ["", "Faible", "Moyen", "Fort"];

  return (
    <div className="bg-white rounded-3xl shadow-2xl p-8 animate-slide-up">
      <div className="text-center mb-8">
        <h1 className="font-display text-2xl font-bold text-[#111]">Créer un compte</h1>
        <p className="mt-1.5 text-sm text-gray-500">Accédez à tous nos services juridiques</p>
      </div>

      {error && (
        <div className="flex items-start gap-2 rounded-xl bg-red-50 border border-red-100 p-3.5 mb-5 text-sm text-red-600">
          <AlertCircle className="h-4 w-4 mt-0.5 shrink-0" />
          {error}
        </div>
      )}

      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="label">Nom complet <span className="text-red-500">*</span></label>
          <input type="text" value={form.fullName} onChange={(e) => handleChange("fullName", e.target.value)}
            placeholder="Jean Dupont" required className="input-field" />
        </div>

        <div>
          <label className="label">Email <span className="text-red-500">*</span></label>
          <input type="email" value={form.email} onChange={(e) => handleChange("email", e.target.value)}
            placeholder="vous@exemple.fr" required autoComplete="email" className="input-field" />
        </div>

        <div>
          <label className="label">Téléphone <span className="text-gray-400 font-normal">(optionnel)</span></label>
          <input type="tel" value={form.phone} onChange={(e) => handleChange("phone", e.target.value)}
            placeholder="+33 6 12 34 56 78" className="input-field" />
        </div>

        <div>
          <label className="label">Mot de passe <span className="text-red-500">*</span></label>
          <div className="relative">
            <input type={showPassword ? "text" : "password"} value={form.password}
              onChange={(e) => handleChange("password", e.target.value)}
              placeholder="8 caractères minimum" required className="input-field pr-10" />
            <button type="button" onClick={() => setShowPassword(!showPassword)}
              className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
              {showPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
            </button>
          </div>
          {form.password.length > 0 && (
            <div className="mt-2 flex items-center gap-2">
              <div className="flex gap-1 flex-1">
                {[1,2,3].map((level) => (
                  <div key={level} className={`h-1 flex-1 rounded-full transition-colors ${level <= passwordStrength ? strengthColors[passwordStrength] : "bg-gray-200"}`} />
                ))}
              </div>
              <span className={`text-xs font-medium ${passwordStrength === 1 ? "text-red-500" : passwordStrength === 2 ? "text-amber-500" : "text-secondary"}`}>
                {strengthLabels[passwordStrength]}
              </span>
            </div>
          )}
        </div>

        <div>
          <label className="label">Confirmer le mot de passe <span className="text-red-500">*</span></label>
          <div className="relative">
            <input type={showPassword ? "text" : "password"} value={form.confirm}
              onChange={(e) => handleChange("confirm", e.target.value)}
              placeholder="Répétez le mot de passe" required className="input-field pr-10" />
            {form.confirm && (
              <div className="absolute right-3 top-1/2 -translate-y-1/2">
                {form.confirm === form.password
                  ? <CheckCircle2 className="h-4 w-4 text-secondary" />
                  : <AlertCircle className="h-4 w-4 text-red-400" />}
              </div>
            )}
          </div>
        </div>

        <p className="text-xs text-gray-400">
          En créant un compte, vous acceptez nos{" "}
          <span className="text-primary cursor-not-allowed">Conditions Générales</span> et notre{" "}
          <span className="text-primary cursor-not-allowed">Politique de confidentialité</span>.
        </p>

        <button type="submit" disabled={loading} className="btn-primary w-full py-3.5 mt-1">
          {loading ? (
            <><Loader2 className="h-4 w-4 animate-spin" />Création du compte...</>
          ) : (
            <><UserPlus className="h-4 w-4" />Créer mon compte</>
          )}
        </button>
      </form>

      <p className="mt-6 text-center text-sm text-gray-500">
        Déjà un compte ?{" "}
        <Link href="/login" className="font-semibold text-primary hover:underline">Se connecter</Link>
      </p>
    </div>
  );
}