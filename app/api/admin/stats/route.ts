// app/api/admin/stats/route.ts
import { NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/db";

export async function GET() {
  try {
    const session = await getServerSession(authOptions);
    if (!session || session.user.role !== "admin") {
      return NextResponse.json({ error: "Non autorisé" }, { status: 403 });
    }

    const [
      totalUsers,
      totalRequests,
      requestsByStatus,
      requestsByService,
      recentRequests,
    ] = await Promise.all([
      prisma.user.count(),
      prisma.request.count(),
      prisma.request.groupBy({ by: ["status"], _count: { _all: true } }),
      prisma.request.groupBy({
        by: ["serviceId"],
        _count: { _all: true },
        orderBy: { _count: { serviceId: "desc" } },
        take: 5,
      }),
      prisma.request.findMany({
        take: 10,
        orderBy: { createdAt: "desc" },
        include: {
          user: { select: { fullName: true, email: true } },
          service: { select: { name: true } },
        },
      }),
    ]);

    // Enrichir les stats par service avec les noms
    const serviceIds = requestsByService.map((r) => r.serviceId);
    const services = await prisma.service.findMany({
      where: { id: { in: serviceIds } },
      select: { id: true, name: true },
    });
    const serviceMap = Object.fromEntries(services.map((s) => [s.id, s.name]));

    return NextResponse.json({
      totalUsers,
      totalRequests,
      requestsByStatus: requestsByService.map((r) => ({
        serviceId: r.serviceId,
        serviceName: serviceMap[r.serviceId] || "Inconnu",
        count: r._count._all,
      })),
      statusBreakdown: requestsByStatus.map((r) => ({
        status: r.status,
        count: r._count._all,
      })),
      recentRequests,
    });
  } catch (error) {
    console.error("[ADMIN_STATS]", error);
    return NextResponse.json({ error: "Erreur serveur" }, { status: 500 });
  }
}