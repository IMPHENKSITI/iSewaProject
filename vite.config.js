import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],

    // ============================================
    // BUILD CONFIGURATION FOR PRODUCTION
    // ============================================
    build: {
        // Output ke public/build
        outDir: 'public/build',
        
        // Manifest untuk Laravel @vite directive - WAJIB
        manifest: true,

        // Rollup options
        rollupOptions: {
            output: {
                // Naming pattern dengan hash untuk cache busting
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]',
            },
        },

        // Minification - esbuild lebih cepat
        minify: 'esbuild',
        
        // No sourcemaps di production
        sourcemap: false,

        // CSS code splitting
        cssCodeSplit: true,

        // Inline assets < 4KB sebagai base64
        assetsInlineLimit: 4096,

        // Target browser modern
        target: 'es2015',
    },

    // ============================================
    // BASE URL - PENTING UNTUK SHARED HOSTING
    // ============================================
    // Kosongkan - Laravel @vite() akan handle path
    base: '',

    // ============================================
    // SERVER CONFIGURATION (Development)
    // ============================================
    server: {
        host: 'localhost',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    },

    // ============================================
    // RESOLVE - Alias jika diperlukan
    // ============================================
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
