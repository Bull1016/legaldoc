// app/admin/services/page.tsx
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { redirect } from "next/navigation";
import prisma from "@/lib/db";
import Link from "next/link";
import { PlusCircle } from "lucide-react";
import { formatPrice } from "@/lib/utils";
import { AdminServiceActions } from "./service-actions";
import { Metadata } from "next";

export const metadata: Metadata = { title: "Gestion des services" };

export default async function AdminServicesPage() {
  const session = await getServerSession(authOptions);
  if (!session || session.user.role !== "admin") redirect("/dashboard");

  const services = await prisma.service.findMany({
    include: { _count: { select: { requests: true } } },
    orderBy: { createdAt: "asc" },
  });

  return (
    <div className="max-w-6xl mx-auto animate-fade-in">
      <div className="flex items-center justify-between mb-8">
        <div>
          <h1 className="font-display text-2xl font-bold text-[#111]">Services</h1>
          <p className="text-gray-500 mt-1 text-sm">{services.length} service(s) configuré(s)</p>
        </div>
        <Link href="/admin/services/new" className="btn-primary">
          <PlusCircle className="h-4 w-4" />
          Nouveau service
        </Link>
      </div>

      <div className="card overflow-x-auto">
        <table className="w-full text-sm">
          <thead>
            <tr className="border-b border-gray-100">
              {["Nom", "Catégorie", "Prix", "Rôle requis", "Demandes", "Statut", "Actions"].map((h) => (
                <th key={h} className="text-left py-3 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">{h}</th>
              ))}
            </tr>
          </thead>
          <tbody>
            {services.map((service) => (
              <tr key={service.id} className="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                <td className="py-3.5 px-4">
                  <p className="font-semibold text-[#111]">{service.name}</p>
                  <p className="text-xs text-gray-400 mt-0.5 max-w-[200px] truncate">{service.description}</p>
                </td>
                <td className="py-3.5 px-4">
                  <span className="badge bg-gray-100 text-gray-600">{service.category || "—"}</span>
                </td>
                <td className="py-3.5 px-4 font-semibold text-primary">
                  {service.basePrice ? formatPrice(Number(service.basePrice)) : "Sur devis"}
                </td>
                <td className="py-3.5 px-4">
                  <span className="badge bg-blue-50 text-blue-600 capitalize">{service.requiredRole.replace("_", " ")}</span>
                </td>
                <td className="py-3.5 px-4 font-semibold text-[#111]">{service._count.requests}</td>
                <td className="py-3.5 px-4">
                  <span className={`badge ${service.active ? "bg-green-50 text-green-600" : "bg-gray-100 text-gray-400"}`}>
                    {service.active ? "Actif" : "Inactif"}
                  </span>
                </td>
                <td className="py-3.5 px-4">
                  <AdminServiceActions serviceId={service.id} isActive={service.active} />
                </td>
              </tr>
            ))}
          </tbody>
        </table>

        {services.length === 0 && (
          <div className="text-center py-12 text-gray-400">
            <p>Aucun service. Créez votre premier service.</p>
          </div>
        )}
      </div>
    </div>
  );
}