export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "ui-sans-serif", "system-ui"],
                krona: ["Krona One", "ui-sans-serif", "system-ui"],
            },
            colors: {
                brand: "#47663B",
            },
        },
    },
    plugins: [],
};