/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
      light_pink: '#ff6cd7',
      dark_pink: '#ff00b9',
      purple_p: '#8e00ff',
      white_p: '#f8f4fb',
      black_p: '#000000',
      white: '#ffffff',
      black_p_75: 'rgba(0, 0, 0, 0.75)',
    },
    extend: {},
  },
  plugins: [],
}

