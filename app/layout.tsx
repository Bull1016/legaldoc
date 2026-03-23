// app/layout.tsx
import type { Metadata } from "next";
import { Bricolage_Grotesque, DM_Sans } from "next/font/google";
import "./globals.css";
import { Providers } from "@/components/providers";

const bricolage = Bricolage_Grotesque({
  subsets: ["latin"],
  variable: "--font-bricolage",
  display: "swap",
  weight: ["300", "400", "500", "600", "700", "800"],
});

const dmSans = DM_Sans({
  subsets: ["latin"],
  variable: "--font-dm-sans",
  display: "swap",
});

export const metadata: Metadata = {
  title: {
    default: "LegalDoc — Vos démarches juridiques en ligne",
    template: "%s | LegalDoc",
  },
  description:
    "LegalDoc simplifie vos formalités juridiques : création d'entreprise, contrats, dépôt de marque. Rapide, fiable, transparent.",
  keywords: ["juridique", "création entreprise", "contrat", "SARL", "SAS", "dépôt marque"],
  openGraph: {
    type: "website",
    locale: "fr_FR",
    siteName: "LegalDoc",
  },
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fr" className={`${bricolage.variable} ${dmSans.variable}`}>
      <body className="font-body bg-[#F8F9FA] text-[#222] antialiased">
        <Providers>{children}</Providers>
      </body>
    </html>
  );
}
