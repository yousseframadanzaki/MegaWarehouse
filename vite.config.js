import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: './public/storage/build'
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/sass/_variables.scss',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
    ],
});
