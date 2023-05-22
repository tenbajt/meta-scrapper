import { defineConfig } from 'vite';
import { resolve } from 'path';
import liveReload from 'vite-plugin-live-reload';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js'
            ],
            refresh: true
        })
    ]
    // plugins: [
    //     liveReload([__dirname + '/resources/**/*.php']),
    // ],
    // build: {
    //     outDir: 'public/build',
    //     emptyOutDir: true,
    //     assetsDir: 'assets',
    //     manifest: true,
    //     rollupOptions: {
    //         input: {
    //             app: resolve(__dirname, 'resources/js/app.js'),
    //         }
    //     }
    // },
    // server: {
    //     strictPort: true,
    //     port: 5173
    // }
});