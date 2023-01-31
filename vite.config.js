import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'


export default defineConfig({
    // server: {
    //     https: {
    //         key: 'C:/laragon/etc/ssl/laragon.key',
    //         cert: "C:/laragon/etc/ssl/laragon.crt",
    //     },
    //     host: 'biolink.test',
    //     hmr: {
    //         host: 'biolink.test',
    //     },
    // },
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/css/index.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
