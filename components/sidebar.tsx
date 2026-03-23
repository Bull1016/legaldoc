// components/sidebar.tsx
"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { signOut, useSession } from "next-auth/react";
import { Scale, LayoutDashboard, Package, Users, ClipboardList, LogOut, Settings, FileCheck } from "lucide-react";
import { cn } from "@/lib/utils";

interface NavItem {
  label: string;
  href: string;
  icon: React.ElementType;
}

const ADMIN_NAV: NavItem[] = [
  { label: "Vue d'ensemble", href: "/admin", icon: LayoutDashboard },
  { label: "Services", href: "/admin/services", icon: Package },
  { label: "Utilisateurs", href: "/admin/users", icon: Users },
  { label: "Toutes les demandes", href: "/admin/demandes", icon: ClipboardList },
];

const JURISTE_NAV: NavItem[] = [
  { label: "Mes demandes", href: "/juriste", icon: ClipboardList },
  { label: "Demandes assignées", href: "/juriste/assignees", icon: FileCheck },
];

const CLIENT_NAV: NavItem[] = [
  { label: "Mes demandes", href: "/dashboard", icon: ClipboardList },
];

export function Sidebar() {
  const pathname = usePathname();
  const { data: session } = useSession();

  const role = session?.user?.role;
  const navItems =
    role === "admin" ? ADMIN_NAV :
    role === "juriste" || role === "expert_compta" ? JURISTE_NAV :
    CLIENT_NAV;

  return (
    <aside className="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-gray-100 bg-white">
      {/* Logo */}
      <div className="flex h-16 items-center gap-2.5 px-6 border-b border-gray-100">
        <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-primary">
          <Scale className="h-4 w-4 text-white" />
        </div>
        <span className="font-display text-lg font-bold text-[#111]">
          Legal<span className="text-primary">Doc</span>
        </span>
      </div>

      {/* Nav */}
      <nav className="flex-1 overflow-y-auto p-4 space-y-1">
        {navItems.map((item) => {
          const Icon = item.icon;
          const isActive = item.href === "/admin" || item.href === "/juriste" || item.href === "/dashboard"
            ? pathname === item.href
            : pathname.startsWith(item.href);

          return (
            <Link
              key={item.href}
              href={item.href}
              className={cn("nav-link", isActive && "active")}
            >
              <Icon className="h-4 w-4 shrink-0" />
              {item.label}
            </Link>
          );
        })}
      </nav>

      {/* User */}
      <div className="border-t border-gray-100 p-4">
        <div className="flex items-center gap-3 px-3 py-2 rounded-xl bg-gray-50 mb-2">
          <div className="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary text-sm font-bold">
            {session?.user?.name?.charAt(0).toUpperCase()}
          </div>
          <div className="flex-1 min-w-0">
            <p className="text-sm font-medium text-[#111] truncate">{session?.user?.name}</p>
            <p className="text-xs text-gray-400 capitalize">{role?.replace("_", " ")}</p>
          </div>
        </div>
        <button
          onClick={() => signOut({ callbackUrl: "/" })}
          className="nav-link w-full text-red-500 hover:bg-red-50 hover:text-red-600"
        >
          <LogOut className="h-4 w-4 shrink-0" />
          Déconnexion
        </button>
      </div>
    </aside>
  );
}