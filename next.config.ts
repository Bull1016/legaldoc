import type { NextConfig } from "next";

const nextConfig: NextConfig = {
    images: {
        remotePatterns: [
            {
                protocol: "https",
                hostname: "*.supabase.co",
                pathname: "/storage/v1/object/public/**",
            },
        ],
    },
    experimental: {
        serverComponentsExternalPackages: ["@prisma/client", "bcrypt"],
    },
};

export default nextConfig;
