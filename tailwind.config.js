/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#10b981',    // emerald, bagus!
        primaryS: {
          100: '# ',
          200: '#a7f3d0',
          300: '#6ee7b7',
          400: '#34d399',
          500: '#10b981', // emerald, utama
          600: '#059669',
          700: '#047857',
          800: '#065f46',
        },
        secondary: '#D8F1A0',  // hijau muda
        accent: '#F3C178',     // kuning lembut
        danger: '#FE5E41',     // merah-oranye, cocok
        warning: '#F97316',    // oranye, opsional
        success: '#22c55e',    // hijau sukses
        dark: '#0B0500',
        gray: {
          100: '#f5f5f5',
          200: '#e5e5e5',
          300: '#d4d4d4',
          400: '#a3a3a3',
          500: '#737373',
        },
      }
    }
  },
  plugins: [],
}