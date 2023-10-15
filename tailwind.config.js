const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
  // Scan templates files to delete unused style and generate optimal CSS file
  content: ["./src/**/*.{php,css}"],
  theme: {
    extend: {
      colors: {
        primary: colors.green,
        secondary: colors.red,
        neutral: colors.sky,
        font: colors.gray,
      }
    },
  },
  plugins: [],
}