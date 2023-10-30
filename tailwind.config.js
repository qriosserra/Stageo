const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
  // Scan templates files to delete unused style and generate optimal CSS file
  darkMode: "class",
  content: ["./src/**/*.{php,css,js}"],
  theme: {
    extend: {
      colors: {
        primary: colors.green,
        secondary: colors.red,
        neutral: colors.sky,
        font: colors.gray,
      },
      backgroundImage: {
        "gradient-radial": "radial-gradient(var(--tw-gradient-stops))",
      },
      animation: {
        float: "float 8s ease-in-out infinite",
      },
      keyframes: {
        float: {
          "0%, 100%": {transform: "translateY(0)"},
          "50%": {transform: "translateY(-10px)"}
        },
        wave: {
          "50%": {transform: "scale(.75)"}
        }
      }
    },
  },
  plugins: [],
}