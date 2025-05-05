/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./ressources/views/**/*.php",  // Vérifie si le dossier est bien "ressources" avec 2 "s"
    "./ressources/views/*.php",     // Parfois nécessaire pour certaines versions
    "./public/*.php",              // Pour index.php
    "./public/**/*.{php,js}",       // Pour tous les fichiers PHP et JS dans public
  ],
  safelist: [ 'bg-green-500', 'text-white', 'p-10', 'text-3xl', 'font-bold' ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0f9ff',
          100: '#e0f2fe',
          500: '#0ea5e9',
          600: '#0284c7',
          700: '#0369a1',
        },
      },
    },
  },
  plugins: [],
}