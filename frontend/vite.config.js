import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import { fileURLToPath, URL } from 'node:url';

export default defineConfig({
  plugins: [vue(), tailwindcss()],
  server: {
    port: 5173,
    host: '0.0.0.0',
    // Proxy is not needed in Docker since browser makes requests directly
    // The frontend .env file sets VITE_API_URL to http://localhost:8000/api
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
});



