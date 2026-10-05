import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import symfony from '@symfony/reprise/vite';

export default defineConfig({
    input: {
        app: './assets/js/app.js',
    },
    plugins: [
        vue(),
        symfony({
            devServerOrigin: 'http://127.0.0.1:5174',
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5174,
        strictPort: true,
        cors: true,
        watch: {
            usePolling: true,
        },
    },
});
