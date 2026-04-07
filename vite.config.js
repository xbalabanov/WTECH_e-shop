import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin-product.css',
                'resources/css/admin.css',
                'resources/css/cart.css',
                'resources/css/category-template.css',
                'resources/css/checkout.css',
                'resources/css/homepage.css',
                'resources/css/login-register.css',
                'resources/css/order-details.css',
                'resources/css/product.css',
                'resources/css/profile.css',
                'resources/css/style.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
