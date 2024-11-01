import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {  darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
   './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: {
                  600: '#4CAF50',
                  500: '#4CAF50',
                  700: '#388E3C',
                },
                darkGreen: '#4C6B47',
                lightGreen: '#A8C3A1',
                beige: '#E5E2C5',
                mintGreen: '#5E8C61',
                lightGray: '#F5F5F0',
                yellow: {
                  400: '#FFEB3B',
                },
              },
        },
    },

    plugins: [forms],
};
