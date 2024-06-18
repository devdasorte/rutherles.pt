import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            
            refresh: ['resources/views/rifa/admin/**'],
        }),
        
    ],
    server: {
        host:'rutherles.pt',
        https: {
            key: fs.readFileSync(path.resolve(__dirname, 'cert/privkey.pem')),
            cert: fs.readFileSync(path.resolve(__dirname, 'cert/fullchain.pem')),
        },
        port: 3000, // ou qualquer porta que você preferir
    },
    build: {
        outDir: 'public/assets/build',
    },
});
