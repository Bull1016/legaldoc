// app/services/[id]/page.tsx
import { notFound } from "next/navigation";
import { Navbar } from "@/components/navbar";
import { Footer } from "@/components/footer";
import { RequestForm } from "@/components/request-form";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/db";
import { formatPrice } from "@/lib/utils";
import { Building2, FileText, Shield, Rocket, Edit, Scale, ArrowLeft, Clock, Users, CheckCircle2, Lock } from "lucide-react";
import Link from "next/link";
import { Metadata } from "next";
import { FormSchema } from "@/types";

const ICONS: Record<string, React.ElementType> = { Building2, FileText, Shield, Rocket, Edit, Scale };

export async function generateMetadata({ params }: { params: { id: string } }): Promise<Metadata> {
  const service = await prisma.service.findUnique({ where: { id: params.id } }).catch(() => null);
  if (!service) return { title: "Service introuvable" };
  return { title: service.name, description: service.description };
}

export default async function ServiceDetailPage({ params }: { params: { id: string } }) {
  const session = await getServerSession(authOptions);

  const service = await prisma.service.findUnique({
    where: { id: params.id, active: true },
    include: { _count: { select: { requests: true } } },
  }).catch(() => null);

  if (!service) notFound();

  const Icon = service.icon ? (ICONS[service.icon] ?? Scale) : Scale;
  const formSchema = service.formSchema as unknown as FormSchema;
  const price = service.basePrice ? Number(service.basePrice) : null;

  return (
    <div className="min-h-screen">
      <Navbar />

      <main className="pb-16">
        {/* Breadcrumb */}
        <div className="bg-white border-b border-gray-100">
          <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4">
            <Link href="/services" className="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-primary transition-colors">
              <ArrowLeft className="h-4 w-4" />
              Retour aux services
            </Link>
          </div>
        </div>

        {/* Hero service */}
        <div className="bg-white border-b border-gray-100 py-10">
          <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div className="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
              <div className="flex items-start gap-5">
                <div className="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-primary/10">
                  <Icon className="h-8 w-8 text-primary" />
                </div>
                <div>
                  {service.category && (
                    <span className="badge bg-primary/10 text-primary mb-2">{service.category}</span>
                  )}
                  <h1 className="font-display text-3xl font-bold text-[#111]">{service.name}</h1>
                  <p className="mt-2 text-gray-500 leading-relaxed max-w-2xl">{service.description}</p>

                  <div className="mt-4 flex flex-wrap gap-4 text-sm text-gray-500">
                    <span className="flex items-center gap-1.5"><Clock className="h-4 w-4 text-primary" />Traitement sous 48–72h</span>
                    <span className="flex items-center gap-1.5"><Users className="h-4 w-4 text-primary" />{service._count.requests}+ demandes traitées</span>
                    <span className="flex items-center gap-1.5"><Lock className="h-4 w-4 text-primary" />Données sécurisées</span>
                  </div>
                </div>
              </div>

              <div className="shrink-0 bg-primary/5 rounded-2xl p-6 min-w-[200px]">
                <p className="text-sm text-gray-500 mb-1">Prix indicatif</p>
                <p className="font-display text-3xl font-extrabold text-primary">
                  {price ? formatPrice(price) : "Sur devis"}
                </p>
                {price && <p className="text-xs text-gray-400 mt-1">HT — à partir de</p>}
                <div className="mt-4 space-y-1.5">
                  {["Juriste qualifié inclus", "Suivi en temps réel", "Document livré en ligne"].map((item) => (
                    <p key={item} className="flex items-center gap-2 text-xs text-gray-600">
                      <CheckCircle2 className="h-3.5 w-3.5 text-secondary shrink-0" />
                      {item}
                    </p>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Form section */}
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10">
          {!session ? (
            <div className="max-w-lg mx-auto text-center py-16">
              <div className="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/10 mx-auto mb-4">
                <Lock className="h-8 w-8 text-primary" />
              </div>
              <h2 className="font-display text-2xl font-bold text-[#111] mb-3">Connexion requise</h2>
              <p className="text-gray-500 mb-6">Connectez-vous ou créez un compte gratuit pour soumettre votre demande.</p>
              <div className="flex flex-col sm:flex-row gap-3 justify-center">
                <Link href={`/login?callbackUrl=/services/${params.id}`} className="btn-primary">Se connecter</Link>
                <Link href={`/register`} className="btn-secondary">Créer un compte</Link>
              </div>
            </div>
          ) : (
            <div>
              <div className="text-center mb-8">
                <h2 className="font-display text-2xl font-bold text-[#111]">Soumettre ma demande</h2>
                <p className="mt-2 text-sm text-gray-500">Remplissez le formulaire ci-dessous — nos experts s'occupent du reste.</p>
              </div>
              <RequestForm
                serviceId={service.id}
                serviceName={service.name}
                formSchema={formSchema}
              />
            </div>
          )}
        </div>
      </main>

      <Footer />
    </div>
  );
}