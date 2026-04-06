// app/admin/page.tsx
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { redirect } from "next/navigation";
import prisma from "@/lib/db";
import { StatusBadge } from "@/components/status-badge";
import { formatDateTime } from "@/lib/utils";
import { RequestStatus } from "@prisma/client";
import Link from "next/link";
import { Users, Package, ClipboardList, CheckCircle2, Clock, TrendingUp, ArrowRight } from "lucide-react";
import { Metadata } from "next";

export const metadata: Metadata = { title: "Administration" };

export default async function AdminPage() {
  const session = await getServerSession(authOptions);
  if (!session || session.user.role !== "admin") redirect("/dashboard");

  const [totalUsers, totalServices, totalRequests, requestsByStatus, recentRequests] = await Promise.all([
    prisma.user.count(),
    prisma.service.count({ where: { active: true } }),
    prisma.request.count(),
    prisma.request.groupBy({ by: ["status"], _count: { _all: true } }),
    prisma.request.findMany({
      take: 8,
      orderBy: { createdAt: "desc" },
      include: {
        user: { select: { fullName: true, email: true } },
        service: { select: { name: true } },
      },
    }),
  ]);

  const statusMap = Object.fromEntries(requestsByStatus.map((r) => [r.status, r._count._all]));
  const completed = statusMap["completed"] || 0;
  const completionRate = totalRequests > 0 ? Math.round((completed / totalRequests) * 100) : 0;

  return (
    <div className="max-w-6xl mx-auto animate-fade-in">
      <div className="mb-8">
        <h1 className="font-display text-2xl font-bold text-[#111]">Administration</h1>
        <p className="text-gray-500 mt-1 text-sm">Vue d'ensemble de la plateforme</p>
      </div>

      {/* KPIs */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {[
          { label: "Utilisateurs", value: totalUsers, icon: Users, color: "text-primary", bg: "bg-primary/10" },
          { label: "Services actifs", value: totalServices, icon: Package, color: "text-secondary", bg: "bg-secondary/10" },
          { label: "Demandes totales", value: totalRequests, icon: ClipboardList, color: "text-amber-600", bg: "bg-amber-50" },
          { label: "Taux de complétion", value: `${completionRate}%`, icon: TrendingUp, color: "text-purple-600", bg: "bg-purple-50" },
        ].map((kpi) => {
          const Icon = kpi.icon;
          return (
            <div key={kpi.label} className="card">
              <div className="flex items-center justify-between mb-3">
                <div className={`flex h-10 w-10 items-center justify-center rounded-xl ${kpi.bg}`}>
                  <Icon className={`h-5 w-5 ${kpi.color}`} />
                </div>
              </div>
              <p className={`font-display text-3xl font-extrabold ${kpi.color}`}>{kpi.value}</p>
              <p className="text-xs text-gray-500 mt-1">{kpi.label}</p>
            </div>
          );
        })}
      </div>

      {/* Status breakdown + Quick links */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {/* Status breakdown */}
        <div className="card lg:col-span-2">
          <h2 className="font-display font-semibold text-[#111] mb-4">Répartition des demandes</h2>
          <div className="space-y-3">
            {(["submitted", "assigned", "in_review", "completed", "refused", "draft"] as RequestStatus[]).map((status) => {
              const count = statusMap[status] || 0;
              const pct = totalRequests > 0 ? Math.round((count / totalRequests) * 100) : 0;
              return (
                <div key={status} className="flex items-center gap-3">
                  <StatusBadge status={status} size="sm" />
                  <div className="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div
                      className="h-full bg-primary rounded-full transition-all"
                      style={{ width: `${pct}%` }}
                    />
                  </div>
                  <span className="text-sm font-semibold text-[#111] w-8 text-right">{count}</span>
                </div>
              );
            })}
          </div>
        </div>

        {/* Quick links */}
        <div className="card">
          <h2 className="font-display font-semibold text-[#111] mb-4">Actions rapides</h2>
          <div className="space-y-2">
            {[
              { label: "Gérer les services", href: "/admin/services", icon: Package },
              { label: "Gérer les utilisateurs", href: "/admin/users", icon: Users },
              { label: "Toutes les demandes", href: "/admin/demandes", icon: ClipboardList },
            ].map((link) => {
              const Icon = link.icon;
              return (
                <Link key={link.href} href={link.href}
                  className="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                  <Icon className="h-4 w-4 text-primary" />
                  <span className="text-sm font-medium text-[#333] group-hover:text-primary">{link.label}</span>
                  <ArrowRight className="h-3.5 w-3.5 text-gray-300 ml-auto group-hover:text-primary" />
                </Link>
              );
            })}
          </div>
        </div>
      </div>

      {/* Recent requests */}
      <div className="card">
        <div className="flex items-center justify-between mb-4">
          <h2 className="font-display font-semibold text-[#111]">Dernières demandes</h2>
          <Link href="/admin/demandes" className="text-sm text-primary hover:underline">Voir tout →</Link>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="border-b border-gray-100">
                <th className="text-left py-2.5 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Code</th>
                <th className="text-left py-2.5 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Client</th>
                <th className="text-left py-2.5 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Service</th>
                <th className="text-left py-2.5 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
                <th className="text-left py-2.5 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
              </tr>
            </thead>
            <tbody>
              {recentRequests.map((req) => (
                <tr key={req.id} className="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                  <td className="py-3 px-3">
                    <code className="font-mono text-xs font-bold text-primary">{req.uniqueCode}</code>
                  </td>
                  <td className="py-3 px-3">
                    <p className="font-medium text-[#111]">{req.user.fullName}</p>
                    <p className="text-xs text-gray-400">{req.user.email}</p>
                  </td>
                  <td className="py-3 px-3 text-gray-600">{req.service.name}</td>
                  <td className="py-3 px-3">
                    <StatusBadge status={req.status as RequestStatus} size="sm" />
                  </td>
                  <td className="py-3 px-3 text-gray-400 text-xs">{formatDateTime(req.createdAt)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}