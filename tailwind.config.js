module.exports = {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/Livewire/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#1a3a8f',
                    dark: '#122a6d',
                    light: '#2a4da8',
                },
                secondary: {
                    DEFAULT: '#ff6b35',
                    dark: '#e05a2b',
                    light: '#ff8c5a',
                },
                accent: '#00a8e8',
            },
            fontFamily: {
                sans: ['Montserrat', 'sans-serif'],
                heading: ['Orbitron', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
}