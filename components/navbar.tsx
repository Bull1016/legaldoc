// components/navbar.tsx
"use client";

import Link from "next/link";
import { useSession, signOut } from "next-auth/react";
import { useState } from "react";
import { Scale, Menu, X, ChevronDown, User, LogOut, LayoutDashboard, ShieldCheck } from "lucide-react";
import { cn } from "@/lib/utils";

export function Navbar() {
  const { data: session } = useSession();
  const [mobileOpen, setMobileOpen] = useState(false);
  const [userMenuOpen, setUserMenuOpen] = useState(false);

  const dashboardHref =
    session?.user.role === "admin"
      ? "/admin"
      : session?.user.role === "juriste" || session?.user.role === "expert_compta"
      ? "/juriste"
      : "/dashboard";

  return (
    <header className="sticky top-0 z-50 w-full border-b border-gray-200/60 bg-white/95 backdrop-blur-sm">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="flex h-16 items-center justify-between">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-2.5 group">
            <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-primary shadow-sm group-hover:bg-primary-600 transition-colors">
              <Scale className="h-5 w-5 text-white" />
            </div>
            <span className="font-display text-xl font-bold text-[#111]">
              Legal<span className="text-primary">Doc</span>
            </span>
          </Link>

          {/* Desktop nav */}
          <nav className="hidden md:flex items-center gap-1">
            <Link href="/services" className="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-primary transition-colors">
              Services
            </Link>
            <Link href="/suivi" className="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-primary transition-colors">
              Suivi de dossier
            </Link>
          </nav>

          {/* Right side */}
          <div className="flex items-center gap-3">
            {session ? (
              <div className="relative">
                <button
                  onClick={() => setUserMenuOpen(!userMenuOpen)}
                  className="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-[#333] hover:border-primary hover:text-primary transition-all"
                >
                  <div className="flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary text-xs font-bold">
                    {session.user.name?.charAt(0).toUpperCase()}
                  </div>
                  <span className="hidden sm:inline max-w-[120px] truncate">
                    {session.user.name?.split(" ")[0]}
                  </span>
                  <ChevronDown className={cn("h-3.5 w-3.5 transition-transform", userMenuOpen && "rotate-180")} />
                </button>

                {userMenuOpen && (
                  <div className="absolute right-0 mt-2 w-52 rounded-2xl border border-gray-100 bg-white py-2 shadow-xl animate-fade-in">
                    <div className="border-b border-gray-100 px-4 py-2.5 mb-1">
                      <p className="text-xs text-gray-400">Connecté en tant que</p>
                      <p className="text-sm font-semibold text-[#111] truncate">{session.user.name}</p>
                    </div>
                    <Link
                      href={dashboardHref}
                      onClick={() => setUserMenuOpen(false)}
                      className="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors"
                    >
                      <LayoutDashboard className="h-4 w-4" />
                      Tableau de bord
                    </Link>
                    {session.user.role === "admin" && (
                      <Link
                        href="/admin"
                        onClick={() => setUserMenuOpen(false)}
                        className="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors"
                      >
                        <ShieldCheck className="h-4 w-4" />
                        Administration
                      </Link>
                    )}
                    <button
                      onClick={() => { signOut({ callbackUrl: "/" }); setUserMenuOpen(false); }}
                      className="flex w-full items-center gap-3 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors mt-1 border-t border-gray-100"
                    >
                      <LogOut className="h-4 w-4" />
                      Se déconnecter
                    </button>
                  </div>
                )}
              </div>
            ) : (
              <div className="flex items-center gap-2">
                <Link href="/login" className="hidden sm:inline-flex btn-ghost text-sm">
                  Connexion
                </Link>
                <Link href="/register" className="btn-primary text-sm px-4 py-2.5">
                  Commencer
                </Link>
              </div>
            )}

            <button
              onClick={() => setMobileOpen(!mobileOpen)}
              className="md:hidden rounded-lg p-2 text-gray-500 hover:bg-gray-100"
            >
              {mobileOpen ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
            </button>
          </div>
        </div>

        {/* Mobile menu */}
        {mobileOpen && (
          <div className="md:hidden border-t border-gray-100 py-4 space-y-1 animate-fade-in">
            <Link href="/services" onClick={() => setMobileOpen(false)} className="block px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">Services</Link>
            <Link href="/suivi" onClick={() => setMobileOpen(false)} className="block px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">Suivi de dossier</Link>
            {!session && (
              <div className="pt-2 flex flex-col gap-2">
                <Link href="/login" onClick={() => setMobileOpen(false)} className="btn-secondary text-sm">Connexion</Link>
                <Link href="/register" onClick={() => setMobileOpen(false)} className="btn-primary text-sm">Commencer</Link>
              </div>
            )}
          </div>
        )}
      </div>
    </header>
  );
}