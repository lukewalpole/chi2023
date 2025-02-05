/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    // Colour scheme and google font family is included in the config to reduce unnecessary code.
    // Colour scheme is borrowed from this website, number 15: https://visme.co/blog/website-color-schemes/ 
    colors: {
      'red': '#AC3B61',
      'off-white': '#EEE2DC',
      'peach': '#EDC7B7',
      'grey': '#BAB2B5',
      'blue': '#123C69',
    },
    fontFamily: {
      poppins: ['Poppins', 'sans-serif'],
    }
  },
  plugins: [],
}

