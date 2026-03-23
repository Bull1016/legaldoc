// app/services/service-search.tsx
"use client";

import { useRouter, useSearchParams } from "next/navigation";
import { useState, useTransition } from "react";
import { Search, Loader2 } from "lucide-react";
import { cn } from "@/lib/utils";

interface Props {
  categories: string[];
  initialCategory?: string;
  initialSearch?: string;
}

export function ServiceSearch({ categories, initialCategory, initialSearch }: Props) {
  const router = useRouter();
  const [search, setSearch] = useState(initialSearch || "");
  const [activeCategory, setActiveCategory] = useState(initialCategory || "Tous");
  const [isPending, startTransition] = useTransition();

  function apply(cat: string, q: string) {
    const params = new URLSearchParams();
    if (cat && cat !== "Tous") params.set("category", cat);
    if (q) params.set("search", q);
    startTransition(() => {
      router.push(`/services?${params.toString()}`);
    });
  }

  function handleCategory(cat: string) {
    setActiveCategory(cat);
    apply(cat, search);
  }

  function handleSearch(e: React.FormEvent) {
    e.preventDefault();
    apply(activeCategory, search);
  }

  return (
    <div className="flex flex-col sm:flex-row gap-4 items-center">
      {/* Search */}
      <form onSubmit={handleSearch} className="relative flex-1 w-full">
        <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
        <input
          type="text"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          placeholder="Rechercher un service…"
          className="input-field pl-10 pr-10"
        />
        {isPending && (
          <Loader2 className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400 animate-spin" />
        )}
      </form>

      {/* Category filters */}
      <div className="flex gap-2 flex-wrap">
        {categories.map((cat) => (
          <button
            key={cat}
            onClick={() => handleCategory(cat)}
            className={cn(
              "px-4 py-2 rounded-full text-sm font-medium transition-all",
              activeCategory === cat
                ? "bg-primary text-white shadow-sm"
                : "bg-gray-100 text-gray-600 hover:bg-gray-200"
            )}
          >
            {cat}
          </button>
        ))}
      </div>
    </div>
  );
}