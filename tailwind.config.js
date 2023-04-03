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
                sans: ['Inter', 'sans-serif', ...defaultTheme.fontFamily.sans],
            }
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
}

