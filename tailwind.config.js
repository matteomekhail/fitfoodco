import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "1rem",
                sm: "2rem",
                lg: "4rem",
                xl: "6rem",
                "2xl": "8rem",
            },
        },
        fontFamily: {
            body: ["'DM Sans'", "sans-serif"],
        },
    },
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes").light,
                    primary: "#EFE9E4",
                    "primary-content": "#000000",
                    secondary: "#000000",
                    neutral: "#000000",
                    info: "#000000",
                    success: "#000000",
                    warning: "#000000",
                    error: "#000000",
                    "--rounded-box": "0.25rem",
                    "--rounded-btn": "0.25rem",
                },
            },
        ],
    },
    plugins: [forms, require("daisyui")],
};
