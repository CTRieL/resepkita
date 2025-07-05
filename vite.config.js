import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    theme: {
        extend: {
            colors: {
                primary: '#F3C178',  
                secondary: '#D8F1A0',
                accent: '#10b981',   
                danger: '#FE5E41',   
                warning: '#F97316',  
                success: '#22c55e',  
                black: '#0B0500',    
                gray: {
                100: '#f5f5f5',
                200: '#e5e5e5',
                300: '#d4d4d4',
                400: '#a3a3a3',
                500: '#737373',
                },
            }
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
