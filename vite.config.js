import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import livewire from 'vite-plugin-livewire'; // ✅ ADD THIS

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//         }),
//         livewire(), // ✅ ADD THIS TOO
//     ],
//     server: {
//         cors: true,
//     },
// });
