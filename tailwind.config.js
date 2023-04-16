/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './public/js/pages/**/*.js',
        './resources/**/*.vue'
    ],
    theme: {
        extend: {
            container: {
                center: true
            }
        }
    },
    plugins: []
}
