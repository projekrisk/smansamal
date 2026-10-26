import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Fraunces', 'serif'],
            },
            colors: {
                stone: {
                    50: '#F9F8F6',
                    100: '#EFEBE4',
                    800: '#3D3935',
                    900: '#2A2724',
                },
                forest: '#2A5C43',
                terracotta: '#CC7A6B',
            }
        },
    },

    plugins: [forms],
};
