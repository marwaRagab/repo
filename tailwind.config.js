const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    prefix: 'tw-', // Adds 'tw-' prefix to all Tailwind classes
  important: true, // Ensures Tailwind utilities take precedence
  corePlugins: {
    preflight: false, // Disables Tailwind's base styles to prevent conflicts with Bootstrap
  },
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
