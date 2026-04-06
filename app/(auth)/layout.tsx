// app/(auth)/layout.tsx
import Link from "next/link";
import { Scale } from "lucide-react";

export default function AuthLayout({ children }: { children: React.ReactNode }) {
  return (
    <div className="min-h-screen bg-gradient-to-br from-primary-900 via-primary to-primary-700 flex flex-col">
      {/* Logo */}
      <div className="p-6">
        <Link href="/" className="inline-flex items-center gap-2.5 group">
          <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-white/20 backdrop-blur group-hover:bg-white/30 transition-colors">
            <Scale className="h-5 w-5 text-white" />
          </div>
          <span className="font-display text-xl font-bold text-white">
            Legal<span className="text-secondary">Doc</span>
          </span>
        </Link>
      </div>

      {/* Content */}
      <div className="flex-1 flex items-center justify-center px-4 pb-10">
        <div className="w-full max-w-md">
          {children}
        </div>
      </div>

      <div className="p-4 text-center text-xs text-white/40">
        © {new Date().getFullYear()} LegalDoc — Vos données sont protégées
      </div>
    </div>
  );
}