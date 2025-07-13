import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/leaflet.js', 
                'resources/js/home.js',
                'resources/css/app.css',
                'resources/css/leaflet.css', 
                'resources/css/home.css',
                'resources/css/bootstrap-icons.min.css',

            ],
            refresh: true,
        }),

    ],
});
