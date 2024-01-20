import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  server: {
    host: '0.0.0.0',
    port: 5173,
    hmr: {
      clientPort: parseInt(process.env.VITE_PORT ?? 5173),
      host: 'localhost',
    },
  },
  plugins: [
    vue(),
    laravel({
      input: [
        'resources/sass/app.scss',
        'resources/js/app.ts',
      ],
      refresh: true,
    }),
  ],
});
