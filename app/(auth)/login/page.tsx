// app/(auth)/login/page.tsx
"use client";

import { useState } from "react";
import Link from "next/link";
import { useRouter, useSearchParams } from "next/navigation";
import { signIn } from "next-auth/react";
import { Eye, EyeOff, AlertCircle, Loader2, LogIn } from "lucide-react";
import { Metadata } from "next";

export default function LoginPage() {
  const router = useRouter();
  const searchParams = useSearchParams();
  const callbackUrl = searchParams.get("callbackUrl") || "/dashboard";

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const result = await signIn("credentials", {
        email: email.toLowerCase(),
        password,
        redirect: false,
      });

      if (result?.error) {
        setError("Email ou mot de passe incorrect. Vérifiez vos identifiants.");
      } else {
        router.push(callbackUrl);
        router.refresh();
      }
    } catch {
      setError("Une erreur est survenue. Veuillez réessayer.");
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="bg-white rounded-3xl shadow-2xl p-8 animate-slide-up">
      <div className="text-center mb-8">
        <h1 className="font-display text-2xl font-bold text-[#111]">Bienvenue</h1>
        <p className="mt-1.5 text-sm text-gray-500">Connectez-vous à votre espace client</p>
      </div>

      {error && (
        <div className="flex items-start gap-2 rounded-xl bg-red-50 border border-red-100 p-3.5 mb-5 text-sm text-red-600">
          <AlertCircle className="h-4 w-4 mt-0.5 shrink-0" />
          {error}
        </div>
      )}

      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="label">Adresse email</label>
          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            placeholder="vous@exemple.fr"
            required
            autoComplete="email"
            className="input-field"
          />
        </div>

        <div>
          <div className="flex items-center justify-between mb-1.5">
            <label className="label mb-0">Mot de passe</label>
            <span className="text-xs text-gray-400 cursor-not-allowed">Mot de passe oublié ?</span>
          </div>
          <div className="relative">
            <input
              type={showPassword ? "text" : "password"}
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              placeholder="••••••••"
              required
              autoComplete="current-password"
              className="input-field pr-10"
            />
            <button
              type="button"
              onClick={() => setShowPassword(!showPassword)}
              className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
            >
              {showPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
            </button>
          </div>
        </div>

        <button
          type="submit"
          disabled={loading}
          className="btn-primary w-full mt-2 py-3.5"
        >
          {loading ? (
            <><Loader2 className="h-4 w-4 animate-spin" />Connexion...</>
          ) : (
            <><LogIn className="h-4 w-4" />Se connecter</>
          )}
        </button>
      </form>

      <p className="mt-6 text-center text-sm text-gray-500">
        Pas encore de compte ?{" "}
        <Link href="/register" className="font-semibold text-primary hover:underline">
          Créer un compte
        </Link>
      </p>
    </div>
  );
}