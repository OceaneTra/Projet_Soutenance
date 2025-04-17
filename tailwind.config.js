/** @type {import('tailwindcss').Config} */
module.exports = {
  // 1. Configuration du contenu (fichiers à analyser)
  content: [
    "./www/**/*.{html,js,jsx,ts,tsx}",
    "./wwww/index.html",
    
  ],

  // 2. Configuration du thème principal
  theme: {
    // 2.1 Extensions des valeurs par défaut
    extend: {
      // Couleurs personnalisées
      colors: {
        primary: {
          DEFAULT: '#3498db',
          light: '#5dade2',
          dark: '#2874a6'
        },
        green: {
          100: 'oklch(96.2% 0.044 156.743)',
          500: 'oklch(72.3% 0.219 149.579)'
        }
      },
      
      // Typographie
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        mono: ['Fira Code', 'monospace']
      },
      
      // Espacements
      spacing: {
        'sidebar': '250px',
        '128': '32rem'
      },
      
      // Animations
      animation: {
        'spin-slow': 'spin 3s linear infinite'
      }
    },
    
    // 2.2 Surcharge des valeurs par défaut
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px'
    }
  },

  // 3. Variants (états des utilitaires)
  variants: {
    extend: {
      backgroundColor: ['active'],
      textColor: ['hover', 'focus-within']
    }
  },

  // 4. Plugins
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('tailwind-scrollbar-hide')
  ],

  // 5. Mode de compatibilité (optionnel)
  corePlugins: {
    float: false // Désactive les utilitaires float si non utilisés
  }
}