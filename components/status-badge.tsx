// components/status-badge.tsx
import { RequestStatus } from "@prisma/client";
import { cn } from "@/lib/utils";
import { STATUS_LABELS, STATUS_COLORS } from "@/types";
import {
  Clock, Send, UserCheck, Search, CheckCircle2, XCircle,
} from "lucide-react";

const STATUS_ICONS: Record<RequestStatus, React.ReactNode> = {
  draft: <Clock className="h-3 w-3" />,
  submitted: <Send className="h-3 w-3" />,
  assigned: <UserCheck className="h-3 w-3" />,
  in_review: <Search className="h-3 w-3" />,
  completed: <CheckCircle2 className="h-3 w-3" />,
  refused: <XCircle className="h-3 w-3" />,
};

interface StatusBadgeProps {
  status: RequestStatus;
  size?: "sm" | "md";
}

export function StatusBadge({ status, size = "md" }: StatusBadgeProps) {
  return (
    <span
      className={cn(
        "badge gap-1.5",
        STATUS_COLORS[status],
        size === "sm" && "text-xs px-2 py-0.5"
      )}
    >
      {STATUS_ICONS[status]}
      {STATUS_LABELS[status]}
    </span>
  );
}