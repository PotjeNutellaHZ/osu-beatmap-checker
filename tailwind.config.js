/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'osu-pink': '#ff66aa',
                'osu-dark': '#2a2a2a',
            }
        },
    },
    plugins: [],
}
