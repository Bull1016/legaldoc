// components/request-form.tsx
"use client";

import { useState, useRef } from "react";
import { useRouter } from "next/navigation";
import { useSession } from "next-auth/react";
import { Upload, X, FileText, ChevronRight, ChevronLeft, CheckCircle2, AlertCircle, Loader2 } from "lucide-react";
import { cn } from "@/lib/utils";
import { FormSchema, FormStep, FormField } from "@/types";

interface RequestFormProps {
  serviceId: string;
  serviceName: string;
  formSchema: FormSchema;
}

export function RequestForm({ serviceId, serviceName, formSchema }: RequestFormProps) {
  const router = useRouter();
  const { data: session } = useSession();

  const [currentStep, setCurrentStep] = useState(0);
  const [formData, setFormData] = useState<Record<string, string>>({});
  const [uploadedFiles, setUploadedFiles] = useState<{ name: string; url: string; size: number }[]>([]);
  const [uploading, setUploading] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [errors, setErrors] = useState<Record<string, string>>({});
  const [globalError, setGlobalError] = useState("");
  const fileInputRef = useRef<HTMLInputElement>(null);

  const totalSteps = formSchema.steps.length + 1; // +1 pour les documents
  const isDocStep = currentStep === formSchema.steps.length;
  const currentStepData: FormStep | null = isDocStep ? null : formSchema.steps[currentStep];

  function handleChange(fieldId: string, value: string) {
    setFormData((prev) => ({ ...prev, [fieldId]: value }));
    if (errors[fieldId]) setErrors((prev) => { const e = { ...prev }; delete e[fieldId]; return e; });
  }

  function validateStep(): boolean {
    if (!currentStepData) return true;
    const stepErrors: Record<string, string> = {};
    for (const field of currentStepData.fields) {
      if (field.required && !formData[field.id]?.trim()) {
        stepErrors[field.id] = "Ce champ est obligatoire";
      }
    }
    setErrors(stepErrors);
    return Object.keys(stepErrors).length === 0;
  }

  function nextStep() {
    if (validateStep()) setCurrentStep((s) => Math.min(s + 1, totalSteps - 1));
  }
  function prevStep() { setCurrentStep((s) => Math.max(s - 1, 0)); }

  async function handleFileUpload(e: React.ChangeEvent<HTMLInputElement>) {
    const files = Array.from(e.target.files || []);
    if (!files.length) return;
    setUploading(true);
    setGlobalError("");

    for (const file of files) {
      if (file.size > 10 * 1024 * 1024) {
        setGlobalError(`${file.name} dépasse la limite de 10 Mo`);
        continue;
      }
      const fd = new FormData();
      fd.append("file", file);
      fd.append("requestId", "tmp");
      try {
        const res = await fetch("/api/upload", { method: "POST", body: fd });
        const data = await res.json();
        if (res.ok) {
          setUploadedFiles((prev) => [...prev, { name: file.name, url: data.url, size: file.size }]);
        } else {
          setGlobalError(data.error || "Erreur lors de l'upload");
        }
      } catch {
        setGlobalError("Erreur réseau lors de l'upload");
      }
    }
    setUploading(false);
    if (fileInputRef.current) fileInputRef.current.value = "";
  }

  function removeFile(idx: number) {
    setUploadedFiles((prev) => prev.filter((_, i) => i !== idx));
  }

  async function handleSubmit() {
    if (!session) { router.push("/login"); return; }
    setSubmitting(true);
    setGlobalError("");
    try {
      const res = await fetch("/api/requests", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          serviceId,
          formData,
          documentsUploaded: uploadedFiles.map((f) => f.url),
        }),
      });
      const data = await res.json();
      if (res.ok) {
        router.push(`/dashboard?code=${data.request.uniqueCode}&success=1`);
      } else {
        setGlobalError(data.error || "Erreur lors de la soumission");
      }
    } catch {
      setGlobalError("Erreur réseau. Veuillez réessayer.");
    } finally {
      setSubmitting(false);
    }
  }

  return (
    <div className="w-full max-w-2xl mx-auto">
      {/* Progress */}
      <div className="flex items-center justify-between mb-8">
        {Array.from({ length: totalSteps }).map((_, i) => {
          const label = i < formSchema.steps.length
            ? formSchema.steps[i].title
            : "Documents";
          const state = i < currentStep ? "done" : i === currentStep ? "current" : "pending";
          return (
            <div key={i} className="flex items-center flex-1">
              <div className="flex flex-col items-center gap-1">
                <div className={cn("step-dot", state)}>
                  {state === "done" ? <CheckCircle2 className="h-4 w-4" /> : i + 1}
                </div>
                <span className={cn("hidden sm:block text-xs font-medium max-w-[80px] text-center",
                  state === "current" ? "text-primary" : state === "done" ? "text-secondary" : "text-gray-400"
                )}>
                  {label}
                </span>
              </div>
              {i < totalSteps - 1 && (
                <div className={cn("h-0.5 flex-1 mx-2 transition-colors", i < currentStep ? "bg-secondary" : "bg-gray-200")} />
              )}
            </div>
          );
        })}
      </div>

      {/* Step content */}
      <div className="card animate-fade-in">
        {!isDocStep && currentStepData && (
          <div>
            <h3 className="font-display text-xl font-bold text-[#111] mb-6">
              {currentStepData.title}
            </h3>
            <div className="space-y-5">
              {currentStepData.fields.map((field) => (
                <FormFieldComponent
                  key={field.id}
                  field={field}
                  value={formData[field.id] || ""}
                  onChange={(v) => handleChange(field.id, v)}
                  error={errors[field.id]}
                />
              ))}
            </div>
          </div>
        )}

        {isDocStep && (
          <div>
            <h3 className="font-display text-xl font-bold text-[#111] mb-2">
              Pièces justificatives
            </h3>
            <p className="text-sm text-gray-500 mb-5">
              Formats acceptés : PDF, JPG, PNG — Max 10 Mo par fichier
            </p>

            {/* Required docs list */}
            <div className="bg-blue-50 rounded-xl p-4 mb-5">
              <p className="text-sm font-semibold text-blue-700 mb-2">Documents requis :</p>
              <ul className="space-y-1">
                {formSchema.requiredDocuments.map((doc, i) => (
                  <li key={i} className="flex items-center gap-2 text-sm text-blue-600">
                    <FileText className="h-3.5 w-3.5 shrink-0" />
                    {doc}
                  </li>
                ))}
              </ul>
            </div>

            {/* Upload zone */}
            <div
              className="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-primary/50 transition-colors cursor-pointer"
              onClick={() => fileInputRef.current?.click()}
            >
              <Upload className="h-8 w-8 text-gray-300 mx-auto mb-3" />
              <p className="text-sm font-medium text-gray-600">Cliquez pour ajouter des fichiers</p>
              <p className="text-xs text-gray-400 mt-1">ou glissez-déposez vos fichiers ici</p>
              <input
                ref={fileInputRef}
                type="file"
                multiple
                accept=".pdf,.jpg,.jpeg,.png"
                className="hidden"
                onChange={handleFileUpload}
              />
            </div>

            {uploading && (
              <div className="flex items-center gap-2 mt-3 text-sm text-primary">
                <Loader2 className="h-4 w-4 animate-spin" />
                Upload en cours...
              </div>
            )}

            {/* Uploaded files */}
            {uploadedFiles.length > 0 && (
              <div className="mt-4 space-y-2">
                {uploadedFiles.map((file, i) => (
                  <div key={i} className="flex items-center gap-3 rounded-xl bg-green-50 border border-green-100 px-4 py-3">
                    <FileText className="h-4 w-4 text-secondary shrink-0" />
                    <span className="flex-1 text-sm font-medium text-green-700 truncate">{file.name}</span>
                    <span className="text-xs text-green-500">{(file.size / 1024).toFixed(0)} Ko</span>
                    <button onClick={() => removeFile(i)} className="text-green-400 hover:text-red-500 transition-colors">
                      <X className="h-4 w-4" />
                    </button>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}

        {/* Error */}
        {globalError && (
          <div className="mt-4 flex items-start gap-2 rounded-xl bg-red-50 border border-red-100 p-4 text-sm text-red-600">
            <AlertCircle className="h-4 w-4 mt-0.5 shrink-0" />
            {globalError}
          </div>
        )}

        {/* Navigation buttons */}
        <div className="flex justify-between mt-8 pt-6 border-t border-gray-100">
          <button
            onClick={prevStep}
            disabled={currentStep === 0}
            className="btn-secondary disabled:opacity-30"
          >
            <ChevronLeft className="h-4 w-4" />
            Précédent
          </button>

          {currentStep < totalSteps - 1 ? (
            <button onClick={nextStep} className="btn-primary">
              Suivant
              <ChevronRight className="h-4 w-4" />
            </button>
          ) : (
            <button
              onClick={handleSubmit}
              disabled={submitting || uploading}
              className="btn-primary min-w-[160px]"
            >
              {submitting ? (
                <><Loader2 className="h-4 w-4 animate-spin" />Soumission...</>
              ) : (
                <><CheckCircle2 className="h-4 w-4" />Soumettre ma demande</>
              )}
            </button>
          )}
        </div>
      </div>
    </div>
  );
}

function FormFieldComponent({
  field,
  value,
  onChange,
  error,
}: {
  field: FormField;
  value: string;
  onChange: (v: string) => void;
  error?: string;
}) {
  const baseClass = cn("input-field", error && "border-red-400 focus:border-red-400 focus:ring-red-100");

  return (
    <div>
      <label className="label">
        {field.label}
        {field.required && <span className="text-red-500 ml-0.5">*</span>}
      </label>

      {field.type === "textarea" ? (
        <textarea
          value={value}
          onChange={(e) => onChange(e.target.value)}
          placeholder={field.placeholder}
          rows={4}
          className={baseClass}
        />
      ) : field.type === "select" ? (
        <select value={value} onChange={(e) => onChange(e.target.value)} className={baseClass}>
          <option value="">— Sélectionner —</option>
          {field.options?.map((opt) => (
            <option key={opt} value={opt}>{opt}</option>
          ))}
        </select>
      ) : (
        <input
          type={field.type}
          value={value}
          onChange={(e) => onChange(e.target.value)}
          placeholder={field.placeholder}
          className={baseClass}
        />
      )}

      {error && (
        <p className="mt-1 text-xs text-red-500 flex items-center gap-1">
          <AlertCircle className="h-3 w-3" />{error}
        </p>
      )}
    </div>
  );
}