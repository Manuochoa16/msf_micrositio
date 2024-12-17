import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
  plugins: [react()],
  css: {
    postcss: "./postcss.config.cjs",
  },
  define: {
    global: "window", // Define 'global' como 'window' para evitar errores
  },
});
