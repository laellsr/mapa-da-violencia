import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/register.css',
                'resources/css/reportModal.css',
                'resources/js/app.js',
                'resources/js/components/Map.js',
                'resources/js/components/register.js',
                'resources/js/components/ReportModal.js',
                'resources/js/components/Marker.js',
            ],
            refresh: true,
        }),
    ],
});
