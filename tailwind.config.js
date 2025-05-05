/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js,jsx,ts,tsx,vue}", // Adaptez selon votre structure et types de fichiers
    "./public/index.html", // Si vous avez un fichier HTML principal
    // Ajoutez ici tous les chemins vers vos templates
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}