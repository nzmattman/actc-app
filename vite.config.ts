import vue from '@vitejs/plugin-vue';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig } from 'vite';
import svgLoader from 'vite-svg-loader';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.ts'],
      refresh: [...refreshPaths, 'app/Filament/**'],
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    svgLoader(),
  ],

  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources/js'),
      '@ui': path.resolve(__dirname, './resources/js/components/ui'),
      '@svg': path.resolve(__dirname, './resources/svg'),
      '@img': path.resolve(__dirname, './resources/img'),
      '@forms': path.resolve(__dirname, './resources/js/forms'),
    },
  },
});
