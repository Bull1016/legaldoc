import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: "#003087",
          50: "#e6edf7",
          100: "#ccdaef",
          200: "#99b5df",
          300: "#6690cf",
          400: "#336bbf",
          500: "#003087",
          600: "#00276e",
          700: "#001e56",
          800: "#00163d",
          900: "#000d24",
        },
        secondary: {
          DEFAULT: "#00A651",
          50: "#e6f7ee",
          100: "#ccefdd",
          200: "#99dfbb",
          300: "#66cf99",
          400: "#33bf77",
          500: "#00A651",
          600: "#008541",
          700: "#006431",
          800: "#004221",
          900: "#002110",
        },
        accent: {
          DEFAULT: "#F4A261",
          50: "#fef6ee",
          100: "#fdeddd",
          200: "#fbdabb",
          300: "#f9c899",
          400: "#f7b577",
          500: "#F4A261",
          600: "#c3824e",
          700: "#92613b",
          800: "#624128",
          900: "#312015",
        },
      },
      fontFamily: {
        display: ["var(--font-bricolage)", "serif"],
        body: ["var(--font-dm-sans)", "sans-serif"],
      },
      animation: {
        "fade-in": "fadeIn 0.5s ease-in-out",
        "slide-up": "slideUp 0.4s ease-out",
        "slide-in": "slideIn 0.3s ease-out",
      },
      keyframes: {
        fadeIn: {
          "0%": { opacity: "0" },
          "100%": { opacity: "1" },
        },
        slideUp: {
          "0%": { transform: "translateY(16px)", opacity: "0" },
          "100%": { transform: "translateY(0)", opacity: "1" },
        },
        slideIn: {
          "0%": { transform: "translateX(-16px)", opacity: "0" },
          "100%": { transform: "translateX(0)", opacity: "1" },
        },
      },
    },
  },
  plugins: [],
};
export default config;
