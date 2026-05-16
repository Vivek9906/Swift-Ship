import forms from '@tailwindcss/forms';

export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/View/**/*.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        ops: {
          amber: '#f59e0b',
          blue: '#3b82f6',
          navy: '#0f172a',
        },
      },
    },
  },
  plugins: [forms],
};
