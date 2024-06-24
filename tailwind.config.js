import defaultTheme from 'tailwindcss/defaultTheme';
const colors = require("tailwindcss/colors");

import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

import flattenColorPalette from "tailwindcss/lib/util/flattenColorPalette";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/react/**/*.{js,jsx,ts,tsx}',
    ],
    darkMode: 'class', // or 'media' or 'class'

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                spotlight: "spotlight 2s ease .75s 1 forwards",
            },
            keyframes: {
                spotlight: {
                    "0%": {
                        opacity: 0,
                        transform: "translate(-72%, -62%) scale(0.5)",
                    },
                    "100%": {
                        opacity: 1,
                        transform: "translate(-50%,-40%) scale(1)",
                    },
                },
            },
            screens: {
                'xxs': '320px',
                'xs': '475px',
            },
        },
    },

    plugins: [forms, typography, addVariablesForColors],
};

function addVariablesForColors({ addBase, theme }) {
    let allColors = flattenColorPalette(theme("colors"));
    let newVars = Object.fromEntries(
        Object.entries(allColors).map(([key, val]) => [`--${key}`, val])
    );

    addBase({
        ":root": newVars,
    });
}
