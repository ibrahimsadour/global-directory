import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import purgecss from 'vite-plugin-purgecss'; // 👈 أضف هذا السطر

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/home.css',
                'resources/js/home.js',
            ],
            refresh: true,
        }),

        // 👇 أضف هذا Plugin
        purgecss({
            content: [
                './resources/**/*.blade.php',
                './resources/**/*.vue',
                './resources/**/*.js',
            ],
            safelist: [], // لو عندك CSS تستخدمه ديناميكياً أضفه هنا
        }),
    ],
});
