import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // Arquivos CSS específicos
                'resources/css/admin/eventos.css',
                'resources/css/calendario/meus-eventos.css',
                // Arquivos JS específicos
                'resources/js/admin/eventos.js',
                'resources/js/calendario/meus-eventos.js'
            ],
            refresh: true,
        }),
    ],
});