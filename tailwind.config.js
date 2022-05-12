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
            "primary": "#6d28d9",
            "secondary": "#6b7280",
            "accent": "#0ea5e9",
            "neutral": "#3D4451",
            "base-100": "#FFFFFF",
            "info": "#2563eb",
            "success": "#059669",
            "warning": "#fbbf24",
            "error": "#dc2626",
        },
    },
    plugins: [
        require('daisyui')
    ],
}
