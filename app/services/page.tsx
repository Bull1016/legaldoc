// app/services/page.tsx
import { Navbar } from "@/components/navbar";
import { Footer } from "@/components/footer";
import { ServiceCard } from "@/components/service-card";
import prisma from "@/lib/db";
import { Metadata } from "next";
import { ServiceSearch } from "./service-search";

export const metadata: Metadata = {
  title: "Services juridiques en ligne",
  description: "Création d'entreprise, contrats, dépôt de marque. Tous nos services juridiques en ligne.",
};

async function getServices(category?: string, search?: string) {
  try {
    return await prisma.service.findMany({
      where: {
        active: true,
        ...(category && category !== "Tous" && { category }),
        ...(search && {
          OR: [
            { name: { contains: search, mode: "insensitive" } },
            { description: { contains: search, mode: "insensitive" } },
          ],
        }),
      },
      include: { _count: { select: { requests: true } } },
      orderBy: { createdAt: "asc" },
    });
  } catch {
    return [];
  }
}

const CATEGORIES = ["Tous", "Entreprise", "Contrats", "Protection", "Formalites"];

export default async function ServicesPage({
  searchParams,
}: {
  searchParams: { category?: string; search?: string };
}) {
  const category = searchParams.category;
  const search = searchParams.search;
  const services = await getServices(category, search);

  return (
    <div className="min-h-screen">
      <Navbar />

      <main>
        {/* Header */}
        <div className="bg-white border-b border-gray-100 py-10">
          <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p className="text-sm font-semibold uppercase tracking-wider text-primary mb-2">Catalogue</p>
            <h1 className="section-title mb-2">Nos services juridiques</h1>
            <p className="section-subtitle max-w-2xl">
              Tous vos besoins juridiques en ligne. Formulaires guidés, experts qualifiés, suivi en temps réel.
            </p>
          </div>
        </div>

        {/* Search + filters */}
        <div className="sticky top-16 z-10 bg-white border-b border-gray-100 shadow-sm">
          <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4">
            <ServiceSearch categories={CATEGORIES} initialCategory={category} initialSearch={search} />
          </div>
        </div>

        {/* Grid */}
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
          {services.length === 0 ? (
            <div className="text-center py-20">
              <div className="mx-auto h-16 w-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                <span className="text-2xl">🔍</span>
              </div>
              <h3 className="font-display text-xl font-bold text-[#111] mb-2">Aucun service trouvé</h3>
              <p className="text-gray-500">Essayez une autre recherche ou catégorie.</p>
            </div>
          ) : (
            <>
              <p className="text-sm text-gray-400 mb-6">{services.length} service{services.length > 1 ? "s" : ""} disponible{services.length > 1 ? "s" : ""}</p>
              <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {services.map((service) => (
                  <ServiceCard
                    key={service.id}
                    service={{
                      ...service,
                      basePrice: service.basePrice ? Number(service.basePrice) : null,
                    }}
                  />
                ))}
              </div>
            </>
          )}
        </div>
      </main>

      <Footer />
    </div>
  );
}