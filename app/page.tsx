// app/page.tsx
import Link from "next/link";
import { Navbar } from "@/components/navbar";
import { Footer } from "@/components/footer";
import { ServiceCard } from "@/components/service-card";
import prisma from "@/lib/db";
import {
  Shield, Clock, Users, Star, CheckCircle2,
  ArrowRight, Zap, Lock, Headphones,
} from "lucide-react";

async function getFeaturedServices() {
  try {
    return await prisma.service.findMany({
      where: { active: true },
      take: 4,
      orderBy: { createdAt: "asc" },
    });
  } catch {
    return [];
  }
}

const TESTIMONIALS = [
  {
    name: "Sophie Martin",
    role: "Fondatrice — Studio Créatif SAS",
    content: "J'ai créé ma SAS en moins de 5 jours ouvrés. Le suivi en temps réel m'a évité des dizaines d'appels. Je recommande sans hésitation !",
    rating: 5,
  },
  {
    name: "Thomas Durand",
    role: "Gérant — BTP Durand SARL",
    content: "Procédure claire, formulaire simple, juriste réactif. Mon dépôt de marque a été traité rapidement et sans accroc.",
    rating: 5,
  },
  {
    name: "Amina Bensalem",
    role: "DRH — Tech Solutions PME",
    content: "Nous utilisons LegalDoc pour tous nos contrats de travail. Le service est professionnel, le rapport qualité-prix est excellent.",
    rating: 5,
  },
];

const FEATURES = [
  {
    icon: Zap,
    title: "Rapide & efficace",
    description: "Soumettez votre demande en quelques minutes. Nos experts la traitent sous 48–72h ouvrées.",
  },
  {
    icon: Lock,
    title: "100% sécurisé",
    description: "Vos documents sont chiffrés et hébergés en Europe. Confidentialité garantie.",
  },
  {
    icon: Shield,
    title: "Experts qualifiés",
    description: "Chaque demande est traitée par un juriste ou expert-comptable spécialisé.",
  },
  {
    icon: Headphones,
    title: "Suivi en temps réel",
    description: "Votre code unique vous permet de suivre votre dossier à chaque étape, 24h/24.",
  },
];

export default async function HomePage() {
  const services = await getFeaturedServices();

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* HERO */}
      <section className="relative overflow-hidden hero-gradient hero-pattern">
        <div className="absolute inset-0 bg-[url('/grid.svg')] opacity-5" />
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-28">
          <div className="max-w-3xl">
            <div className="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm text-white/90 mb-6 backdrop-blur-sm">
              <Zap className="h-3.5 w-3.5 text-accent" />
              Vos démarches juridiques simplifiées
            </div>
            <h1 className="font-display text-4xl font-extrabold text-white md:text-5xl lg:text-6xl text-balance">
              Le droit, simple,{" "}
              <span className="text-secondary">rapide</span> et{" "}
              <span className="text-accent">transparent</span>
            </h1>
            <p className="mt-6 text-lg text-white/75 leading-relaxed max-w-2xl">
              Création d'entreprise, rédaction de contrats, dépôt de marque… 
              Nos juristes s'occupent de tout. Suivez votre dossier en temps réel 
              avec votre code unique.
            </p>

            <div className="mt-8 flex flex-wrap gap-4">
              <Link href="/services" className="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-bold text-primary shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                Découvrir les services
                <ArrowRight className="h-4 w-4" />
              </Link>
              <Link href="/suivi" className="inline-flex items-center gap-2 rounded-xl border border-white/30 bg-white/10 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur-sm hover:bg-white/20 transition-all">
                Suivre ma demande
              </Link>
            </div>

            {/* Social proof */}
            <div className="mt-10 flex flex-wrap items-center gap-6">
              <div className="flex items-center gap-1.5">
                {[...Array(5)].map((_, i) => (
                  <Star key={i} className="h-4 w-4 fill-accent text-accent" />
                ))}
                <span className="ml-1 text-sm text-white/75">4.9/5 (200+ avis)</span>
              </div>
              <div className="flex items-center gap-1.5 text-sm text-white/75">
                <Users className="h-4 w-4" />
                +1 500 clients satisfaits
              </div>
              <div className="flex items-center gap-1.5 text-sm text-white/75">
                <Clock className="h-4 w-4" />
                Traitement sous 48–72h
              </div>
            </div>
          </div>
        </div>

        {/* Decorative blob */}
        <div className="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-secondary/20 blur-3xl" />
        <div className="absolute -bottom-32 right-32 h-64 w-64 rounded-full bg-accent/15 blur-3xl" />
      </section>

      {/* FEATURES */}
      <section className="py-16 bg-white">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {FEATURES.map((f) => {
              const Icon = f.icon;
              return (
                <div key={f.title} className="flex flex-col items-start gap-3 p-6 rounded-2xl bg-gray-50 border border-gray-100">
                  <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10">
                    <Icon className="h-5 w-5 text-primary" />
                  </div>
                  <h3 className="font-display font-semibold text-[#111]">{f.title}</h3>
                  <p className="text-sm text-gray-500 leading-relaxed">{f.description}</p>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* SERVICES */}
      <section className="py-16">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex items-end justify-between mb-10">
            <div>
              <p className="text-sm font-semibold uppercase tracking-wider text-primary mb-2">Nos services</p>
              <h2 className="section-title">Ce que nous faisons pour vous</h2>
            </div>
            <Link href="/services" className="hidden sm:inline-flex btn-secondary">
              Voir tout
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>

          {services.length > 0 ? (
            <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
              {services.map((service) => (
                <ServiceCard key={service.id} service={{
                  ...service,
                  basePrice: service.basePrice ? Number(service.basePrice) : null,
                }} />
              ))}
            </div>
          ) : (
            <div className="text-center py-12 text-gray-400">
              <p>Aucun service disponible pour le moment.</p>
            </div>
          )}

          <div className="mt-8 text-center sm:hidden">
            <Link href="/services" className="btn-secondary">
              Voir tous les services
            </Link>
          </div>
        </div>
      </section>

      {/* HOW IT WORKS */}
      <section className="py-16 bg-white">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <p className="text-sm font-semibold uppercase tracking-wider text-primary mb-2">Comment ça marche</p>
            <h2 className="section-title">En 3 étapes simples</h2>
          </div>

          <div className="grid grid-cols-1 gap-8 md:grid-cols-3 relative">
            <div className="hidden md:block absolute top-10 left-1/3 right-1/3 h-0.5 bg-gradient-to-r from-primary/20 via-primary to-primary/20" />
            {[
              { step: "01", title: "Choisissez votre service", desc: "Parcourez notre catalogue et sélectionnez le service correspondant à votre besoin." },
              { step: "02", title: "Remplissez le formulaire", desc: "Notre formulaire guidé vous demande uniquement les informations nécessaires. Uploadez vos pièces." },
              { step: "03", title: "Suivez votre dossier", desc: "Recevez votre code unique et suivez l'avancement de votre demande en temps réel." },
            ].map((item) => (
              <div key={item.step} className="relative flex flex-col items-center text-center p-6">
                <div className="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/10 border-2 border-primary/20 mb-4 text-2xl font-display font-bold text-primary">
                  {item.step}
                </div>
                <h3 className="font-display text-lg font-bold text-[#111] mb-2">{item.title}</h3>
                <p className="text-sm text-gray-500 leading-relaxed">{item.desc}</p>
              </div>
            ))}
          </div>

          <div className="mt-10 text-center">
            <Link href="/register" className="btn-primary text-base px-8 py-4">
              Commencer maintenant
              <ArrowRight className="h-5 w-5" />
            </Link>
          </div>
        </div>
      </section>

      {/* TESTIMONIALS */}
      <section className="py-16 bg-primary/[0.03]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <p className="text-sm font-semibold uppercase tracking-wider text-primary mb-2">Témoignages</p>
            <h2 className="section-title">Ce que disent nos clients</h2>
          </div>

          <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
            {TESTIMONIALS.map((t) => (
              <div key={t.name} className="card">
                <div className="flex gap-1 mb-4">
                  {[...Array(t.rating)].map((_, i) => (
                    <Star key={i} className="h-4 w-4 fill-accent text-accent" />
                  ))}
                </div>
                <p className="text-sm text-gray-600 leading-relaxed mb-4">"{t.content}"</p>
                <div className="flex items-center gap-3 pt-4 border-t border-gray-100">
                  <div className="flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-sm">
                    {t.name.charAt(0)}
                  </div>
                  <div>
                    <p className="text-sm font-semibold text-[#111]">{t.name}</p>
                    <p className="text-xs text-gray-400">{t.role}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA SECTION */}
      <section className="py-16 bg-primary">
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="font-display text-3xl font-bold text-white md:text-4xl text-balance">
            Prêt à simplifier vos démarches juridiques ?
          </h2>
          <p className="mt-4 text-lg text-white/70">
            Rejoignez plus de 1 500 entrepreneurs et particuliers qui nous font confiance.
          </p>
          <div className="mt-8 flex flex-wrap justify-center gap-4">
            <Link href="/register" className="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-bold text-primary hover:shadow-lg transition-all">
              Créer un compte gratuit
              <ArrowRight className="h-4 w-4" />
            </Link>
            <Link href="/services" className="inline-flex items-center gap-2 rounded-xl border border-white/30 px-6 py-3.5 text-sm font-semibold text-white hover:bg-white/10 transition-all">
              Voir les services
            </Link>
          </div>

          <div className="mt-8 flex flex-wrap justify-center gap-6 text-sm text-white/60">
            {["Sans engagement", "Paiement sécurisé", "Support réactif", "RGPD conforme"].map((item) => (
              <span key={item} className="flex items-center gap-1.5">
                <CheckCircle2 className="h-4 w-4 text-secondary" />
                {item}
              </span>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
}