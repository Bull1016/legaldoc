// app/admin/layout.tsx
import { Sidebar } from "@/components/sidebar";

export default function AdminLayout({ children }: { children: React.ReactNode }) {
  return (
    <div className="flex min-h-screen bg-[#F8F9FA]">
      <Sidebar />
      <div className="flex-1 pl-64">
        <main className="p-8">{children}</main>
      </div>
    </div>
  );
}