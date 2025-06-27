import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'fixed', 'bottom-4', 'left-1/2', '-translate-x-1/2',
        'bg-blue-600', 'rounded-3xl', 'flex', 'justify-between', 'items-center',
        'p-3', 'text-white', 'md:hidden', 'text-xs',
        'w-5', 'h-5', 'mb-1', 'w-10', 'h-10', 'rounded-full', 'text-blue-600', '-mt-8', 'shadow-lg',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
