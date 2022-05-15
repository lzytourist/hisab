module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {},
        fontFamily: {
            'noto-sans': ['Noto Sans', 'sans-serif']
        },
        hisab: {
            "primary": "#A72608",
            "secondary": "#090C02",
            "accent": "#EF4B4C",
            "neutral": "#BBC5AA",
            "base-100": "#0B0A07",
            "info": "#3FA7D6",
            "success": "#2FBF71",
            "warning": "#EC4E20",
            "error": "#0B0A07",
        },
    },
    plugins: [
        require('daisyui')
    ],
}
