// components/service-card.tsx
import Link from "next/link";
import {
  Building2, FileText, Shield, Rocket, Edit, X,
  Landmark, Scale, Briefcase, FileCheck,
} from "lucide-react";
import { formatPrice } from "@/lib/utils";
import { cn } from "@/lib/utils";

const ICONS: Record<string, React.ElementType> = {
  Building2, FileText, Shield, Rocket, Edit, X,
  Landmark, Scale, Briefcase, FileCheck,
};

const CATEGORY_COLORS: Record<string, string> = {
  Entreprise: "bg-blue-50 text-blue-600",
  Contrats: "bg-green-50 text-green-600",
  Protection: "bg-purple-50 text-purple-600",
  Formalites: "bg-orange-50 text-orange-600",
};

interface ServiceCardProps {
  service: {
    id: string;
    name: string;
    description: string;
    category: string | null;
    basePrice: number | string | null;
    icon: string | null;
    active: boolean;
  };
  compact?: boolean;
}

export function ServiceCard({ service, compact = false }: ServiceCardProps) {
  const IconComponent = service.icon ? (ICONS[service.icon] ?? Scale) : Scale;
  const categoryColor = service.category ? (CATEGORY_COLORS[service.category] ?? "bg-gray-100 text-gray-600") : "bg-gray-100 text-gray-600";

  return (
    <Link href={`/services/${service.id}`} className="group block">
      <div className={cn(
        "card-hover h-full flex flex-col",
        !service.active && "opacity-60"
      )}>
        <div className="flex items-start gap-4">
          <div className={cn(
            "flex h-12 w-12 shrink-0 items-center justify-center rounded-xl transition-colors",
            categoryColor
          )}>
            <IconComponent className="h-6 w-6" />
          </div>
          <div className="flex-1 min-w-0">
            {service.category && (
              <span className={cn("badge mb-1.5 text-xs", categoryColor)}>
                {service.category}
              </span>
            )}
            <h3 className="font-display font-semibold text-[#111] group-hover:text-primary transition-colors line-clamp-2">
              {service.name}
            </h3>
          </div>
        </div>

        {!compact && (
          <p className="mt-3 text-sm text-gray-500 leading-relaxed line-clamp-3">
            {service.description}
          </p>
        )}

        <div className="mt-auto pt-4 flex items-center justify-between">
          <span className="text-lg font-bold text-primary">
            {service.basePrice
              ? `À partir de ${formatPrice(parseFloat(service.basePrice as string))}`
              : "Sur devis"}
          </span>
          <span className="text-xs font-medium text-primary group-hover:underline">
            En savoir plus →
          </span>
        </div>
      </div>
    </Link>
  );
}