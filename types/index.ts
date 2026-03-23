// types/index.ts
import { Role, RequestStatus, RequiredRole } from "@prisma/client";

export type { Role, RequestStatus, RequiredRole };

export interface FormField {
  id: string;
  label: string;
  type: "text" | "textarea" | "number" | "date" | "select" | "email" | "tel";
  required: boolean;
  placeholder?: string;
  options?: string[];
}

export interface FormStep {
  title: string;
  fields: FormField[];
}

export interface FormSchema {
  steps: FormStep[];
  requiredDocuments: string[];
}

export interface ServiceWithCount {
  id: string;
  name: string;
  description: string;
  category: string | null;
  basePrice: number | null;
  formSchema: FormSchema;
  requiredRole: RequiredRole;
  active: boolean;
  icon: string | null;
  createdAt: Date;
  _count?: { requests: number };
}

export interface RequestWithDetails {
  id: string;
  uniqueCode: string;
  userId: string;
  serviceId: string;
  status: RequestStatus;
  formData: Record<string, unknown>;
  documentsUploaded: string[];
  assignedTo: string | null;
  finalDocumentUrl: string | null;
  notesInternal: string | null;
  refusalReason: string | null;
  createdAt: Date;
  updatedAt: Date;
  user?: {
    id: string;
    fullName: string;
    email: string;
    phone: string | null;
  };
  service?: {
    id: string;
    name: string;
    category: string | null;
    requiredRole: RequiredRole;
  };
  assignedUser?: {
    id: string;
    fullName: string;
    email: string;
  } | null;
}

export const STATUS_LABELS: Record<RequestStatus, string> = {
  draft: "Brouillon",
  submitted: "Soumise",
  assigned: "Assignée",
  in_review: "En cours d'examen",
  completed: "Terminée",
  refused: "Refusée",
};

export const STATUS_COLORS: Record<RequestStatus, string> = {
  draft: "bg-gray-100 text-gray-600",
  submitted: "bg-blue-100 text-blue-700",
  assigned: "bg-purple-100 text-purple-700",
  in_review: "bg-amber-100 text-amber-700",
  completed: "bg-green-100 text-green-700",
  refused: "bg-red-100 text-red-700",
};

export const CATEGORY_LABELS: Record<string, string> = {
  Entreprise: "Entreprise",
  Contrats: "Contrats",
  Formalites: "Formalités",
  Protection: "Protection",
};
