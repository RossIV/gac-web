module.exports = {
    content: [],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
}
