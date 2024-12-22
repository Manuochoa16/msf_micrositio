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
  server: {
    proxy: {
      "/api.php": {
        target: "http://localhost:8000", // URL del backend
        changeOrigin: true, // Cambia el origen de la solicitud al backend
        rewrite: (path) => path.replace(/^\/api.php/, "/api.php"), // Reescribe el path si es necesario
      },
    },
  },
});
