// components/footer.tsx
import Link from "next/link";
import { Scale, Mail, Phone } from "lucide-react";

export function Footer() {
  return (
    <footer className="border-t border-gray-200 bg-white">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
          {/* Brand */}
          <div className="lg:col-span-1">
            <Link href="/" className="flex items-center gap-2.5 mb-4">
              <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-primary">
                <Scale className="h-5 w-5 text-white" />
              </div>
              <span className="font-display text-xl font-bold text-[#111]">
                Legal<span className="text-primary">Doc</span>
              </span>
            </Link>
            <p className="text-sm text-gray-500 leading-relaxed">
              Vos démarches juridiques en ligne. Rapide, fiable, transparent.
            </p>
            <div className="mt-4 space-y-2">
              <a href="mailto:contact@legaldoc.fr" className="flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
                <Mail className="h-4 w-4" />contact@legaldoc.fr
              </a>
              <a href="tel:+33123456789" className="flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
                <Phone className="h-4 w-4" />+33 1 23 45 67 89
              </a>
            </div>
          </div>

          {/* Services */}
          <div>
            <h4 className="font-display font-semibold text-[#111] mb-3">Services</h4>
            <ul className="space-y-2">
              {["Création d'entreprise", "Rédaction de contrats", "Dépôt de marque", "Formalités légales"].map((s) => (
                <li key={s}>
                  <Link href="/services" className="text-sm text-gray-500 hover:text-primary transition-colors">
                    {s}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Compte */}
          <div>
            <h4 className="font-display font-semibold text-[#111] mb-3">Mon compte</h4>
            <ul className="space-y-2">
              {[
                { label: "Se connecter", href: "/login" },
                { label: "Créer un compte", href: "/register" },
                { label: "Suivre ma demande", href: "/suivi" },
                { label: "Tableau de bord", href: "/dashboard" },
              ].map((l) => (
                <li key={l.href}>
                  <Link href={l.href} className="text-sm text-gray-500 hover:text-primary transition-colors">
                    {l.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Légal */}
          <div>
            <h4 className="font-display font-semibold text-[#111] mb-3">Informations</h4>
            <ul className="space-y-2">
              {["Mentions légales", "Politique de confidentialité", "CGV", "À propos"].map((s) => (
                <li key={s}>
                  <span className="text-sm text-gray-400 cursor-default">{s}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="mt-10 border-t border-gray-100 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
          <p className="text-xs text-gray-400">
            © {new Date().getFullYear()} LegalDoc. Tous droits réservés.
          </p>
          <p className="text-xs text-gray-400">
            LegalDoc n'est pas un cabinet d'avocats. Les services proposés sont des formalités administratives.
          </p>
        </div>
      </div>
    </footer>
  );
}