import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import i18n from 'laravel-vue-i18n/vite';

export default defineConfig({
    server: {
        port: '5177'
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/scss/app.scss',  'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        i18n()
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
})
