import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// EXISTING CODE UNCHANGED: plugins array preserved
export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  // ADD THIS: production build output config for Render.com
  build: {
    manifest: true,
    outDir: 'public/build',
    rollupOptions: {
      output: {
        manualChunks: undefined,
      },
    },
  },
});

