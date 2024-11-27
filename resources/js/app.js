import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Toast, { POSITION } from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import 'bootstrap/dist/css/bootstrap.min.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast, {
                position: POSITION.BOTTOM_RIGHT,
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});










// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({ el, App, props, plugin }) {
//         // Create the Vue application
//         const app = createApp({ render: () => h(App, props) });

//         // Use Inertia plugin
//         app.use(plugin);

//         // Use Ziggy for route handling
//         app.use(ZiggyVue);

//         // Use Toast plugin
//         app.use(Toast, {
//             position: POSITION.BOTTOM_RIGHT,
//         });

//         // Mount the Vue application
//         app.mount(el);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });
