/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/views/**/*.php"
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
        require("@tenbajt/tailwind-ui")
    ],
}