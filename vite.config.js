import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/filament/admin/theme.css", "resources/js/app.js"],
      refresh: [
        "resources/views/**/*.blade.php",
        "app/Http/Controllers/**/*.php",
        "app/Livewire/**/*.php",
        "app/Filament/**/*.php",
        "app/Providers/Filament/AdminPanelProvider.php",
        "routes/**/*.php",
        "public/js/alpine.js"
      ]
    }),
    tailwindcss()
  ]
});
