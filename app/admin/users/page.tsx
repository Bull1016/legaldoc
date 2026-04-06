// app/admin/users/page.tsx
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { redirect } from "next/navigation";
import prisma from "@/lib/db";
import { formatDate } from "@/lib/utils";
import { Users } from "lucide-react";
import { AdminUserRoleEditor } from "./user-role-editor";
import { Metadata } from "next";

export const metadata: Metadata = { title: "Gestion des utilisateurs" };

const ROLE_LABELS: Record<string, string> = {
  client: "Client",
  admin: "Administrateur",
  juriste: "Juriste",
  expert_compta: "Expert-comptable",
};

const ROLE_COLORS: Record<string, string> = {
  client: "bg-gray-100 text-gray-600",
  admin: "bg-red-100 text-red-600",
  juriste: "bg-blue-100 text-blue-600",
  expert_compta: "bg-purple-100 text-purple-600",
};

export default async function AdminUsersPage() {
  const session = await getServerSession(authOptions);
  if (!session || session.user.role !== "admin") redirect("/dashboard");

  const users = await prisma.user.findMany({
    select: {
      id: true,
      email: true,
      fullName: true,
      phone: true,
      role: true,
      createdAt: true,
      _count: { select: { requests: true } },
    },
    orderBy: { createdAt: "desc" },
  });

  return (
    <div className="max-w-6xl mx-auto animate-fade-in">
      <div className="flex items-center justify-between mb-8">
        <div>
          <h1 className="font-display text-2xl font-bold text-[#111]">Utilisateurs</h1>
          <p className="text-gray-500 mt-1 text-sm">{users.length} utilisateur(s) inscrit(s)</p>
        </div>
      </div>

      {/* Stats by role */}
      <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        {(["client", "juriste", "expert_compta", "admin"] as const).map((role) => {
          const count = users.filter((u) => u.role === role).length;
          return (
            <div key={role} className="card text-center py-4">
              <p className={`font-display text-2xl font-bold`}>{count}</p>
              <span className={`badge mt-1 ${ROLE_COLORS[role]}`}>{ROLE_LABELS[role]}</span>
            </div>
          );
        })}
      </div>

      <div className="card overflow-x-auto">
        <table className="w-full text-sm">
          <thead>
            <tr className="border-b border-gray-100">
              {["Utilisateur", "Email", "Téléphone", "Rôle", "Demandes", "Inscrit le", "Actions"].map((h) => (
                <th key={h} className="text-left py-3 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">{h}</th>
              ))}
            </tr>
          </thead>
          <tbody>
            {users.map((user) => (
              <tr key={user.id} className="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                <td className="py-3.5 px-4">
                  <div className="flex items-center gap-2.5">
                    <div className="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary text-xs font-bold">
                      {user.fullName.charAt(0).toUpperCase()}
                    </div>
                    <span className="font-semibold text-[#111]">{user.fullName}</span>
                  </div>
                </td>
                <td className="py-3.5 px-4 text-gray-500">{user.email}</td>
                <td className="py-3.5 px-4 text-gray-500">{user.phone || "—"}</td>
                <td className="py-3.5 px-4">
                  <span className={`badge ${ROLE_COLORS[user.role]}`}>
                    {ROLE_LABELS[user.role]}
                  </span>
                </td>
                <td className="py-3.5 px-4 font-semibold text-center">{user._count.requests}</td>
                <td className="py-3.5 px-4 text-gray-400 text-xs">{formatDate(user.createdAt)}</td>
                <td className="py-3.5 px-4">
                  {user.id !== session.user.id && (
                    <AdminUserRoleEditor userId={user.id} currentRole={user.role} />
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
