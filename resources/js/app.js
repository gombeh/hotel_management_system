import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '@tabler/core/dist/js/tabler.min.js'
import Layout from "./Shared/Admin/Layout.vue";

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page =  pages[`./Pages/${name}.vue`].default;

        if (page.layout === undefined) {
            page.layout = Layout;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
