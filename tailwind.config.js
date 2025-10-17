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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#f0f2f5',
                    100: '#d9dde3',
                    200: '#b3bac7',
                    300: '#8d97ab',
                    400: '#67748f',
                    500: '#14213d',
                    600: '#111a35',
                    700: '#0e152c',
                    800: '#0b1023',
                    900: '#080b1a',
                },
                secondary: {
                    50: '#fef7f0',
                    100: '#fdeee0',
                    200: '#fbdcc1',
                    300: '#f9cba2',
                    400: '#f7b983',
                    500: '#f5a764',
                    600: '#c48650',
                    700: '#93653c',
                    800: '#624328',
                    900: '#312214',
                }
            },
        },
    },

    plugins: [forms],
};
