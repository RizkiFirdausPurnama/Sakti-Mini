// tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'royal-blue': '#4361ee', 
        'accent-yellow': '#f72585',
        'soft-orange': '#ff9f1c',
      }
    },
  },
  plugins: [],
}