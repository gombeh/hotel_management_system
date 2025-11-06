import './bootstrap';

import {createApp, h} from 'vue'
import {createInertiaApp, Link, Head} from '@inertiajs/vue3'
import '@tabler/core/dist/js/tabler.min.js'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import {ZiggyVue} from '../../vendor/tightenco/ziggy';


createInertiaApp({
    resolve: async name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        const page = pages[`./Pages/${name}.vue`].default;

        if (page.layout !== undefined) return page

        if (name.startsWith('Landing')) {
            const {default: LandingLayout} = await import("./Shared/Landing/Layout.vue")
            page.layout = LandingLayout
        } else if (name.startsWith('Customer/Auth')) {
            const {default: AuthLayout} = await import("./Shared/Auth/Layout.vue")
            page.layout = AuthLayout
        } else {
            const {default: AdminLayout} = await import("./Shared/Admin/Layout.vue")
            page.layout = AdminLayout
        }
        return page;
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(Toast)
            .use(ZiggyVue)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },
    title: title => `Hotel Homa - ${title}`,
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,

        // The color of the progress bar...
        color: '#29d',

        // Whether to include the default NProgress styles...
        includeCSS: true,

        // Whether the NProgress spinner will be shown...
        showSpinner: false,
    },
})
