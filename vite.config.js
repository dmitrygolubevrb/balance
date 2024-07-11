import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar } from '@quasar/vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },

        }),
        quasar({
            sassVariables: 'resources/css/quasar-variables.sass',
        })
    ],
    server: {
        hmr: {
            host: 'localhost',
            protocol: 'ws',
            port: 6001
        }
    }
});
