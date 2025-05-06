/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js,jsx,ts,tsx,vue,php}", // Adaptez selon votre structure et types de fichiers
    "./public/index.html",
    "./public/*.{html,js,jsx,ts,tsx,vue,php}", // Si vous avez un fichier HTML principal
    // Ajoutez ici tous les chemins vers vos templates
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwind-scrollbar-hide'), // Plugin pour masquer la scrollbar
    require('tailwind-scrollbar'), // Plugin pour personnaliser la scrollbar
  ],
}