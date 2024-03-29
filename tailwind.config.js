/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    important: true,
	content: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
	],
    safeLists: [
        'btn', 'btn-primary'
    ],
    theme: {
        extend: {
            colors: {
                primary: colors.orange,
                secondary: colors.gray,
            },
            container: {
                center: true,
            },
            fontFamily: {
                body: ['Inter', 'sans-serif', ...defaultTheme.fontFamily.sans],
                sans: ['Inter', 'sans-serif', ...defaultTheme.fontFamily.sans],
            }
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
}

