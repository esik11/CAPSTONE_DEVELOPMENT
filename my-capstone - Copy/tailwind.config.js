import defaultTheme from 'tailwindcss/defaultTheme';

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
            },
            colors: {
                'clinic-blue-light': '#F0F8FF', // AliceBlue
                'clinic-blue-medium': '#ADD8E6', // LightBlue
                'clinic-blue-dark': '#2F4F4F', // DarkSlateGray
                'primary': '#3CB371', // Unified Primary Green
                'clinic-green-dark': '#3CB371', // Added for consistency with primary
                'clinic-earth-light': '#F5F5DC', // Beige
                'clinic-earth-medium': '#D2B48C', // Tan
                'clinic-earth-dark': '#8B4513', // SaddleBrown
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
