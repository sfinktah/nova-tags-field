module.exports = {
    mode: 'jit',
    darkMode: 'class',
    content: [
        './resources/js/**/*.vue',
    ],
    important: '.tags-scoped',
    daisyui: {
        themes: [{
            dark: {
                "primary": "#18b69b",
                "secondary": "#22c55e",
                "accent": "#eab308",
                "neutral": "#191D24",
                "base-100": "#2A303C",
                "info": "#06b6d4",
                "success": "#22c55e",
                "warning": "#eab308",
                "error": "#ef4444",
                "blue": "#60a5fa",
                "pink": "#f0abfc",
                "green": "#2dd4bf",
            },
        }, ],
        styled: true,
        base: true,
        utils: true,
        logs: true,
        rtl: false,
        // prefix: '',
        // darkTheme: 'dark',
    },
    plugins: [
        require("daisyui"),
    ],
};


