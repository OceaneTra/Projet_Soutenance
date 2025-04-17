/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./www/**/*.{html,js}",
    "./*.html"
  ],
  theme: {
    extend: {
      colors: {
        // Vous pouvez ajouter vos couleurs personnalisées ici
            green: {
              500: '#3c9e5f',
              100: '#e7eeea'
        }
      },
      spacing: {
        'sidebar': '250px', // Largeur du sidebar
      }
    },
  },
  plugins: [],
}