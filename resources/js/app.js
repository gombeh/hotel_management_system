import './bootstrap';

import {createApp, h} from 'vue'
import {createInertiaApp, Link, Head} from '@inertiajs/vue3'
import '@tabler/core/dist/js/tabler.min.js'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import {ZiggyVue} from '../../vendor/tightenco/ziggy';


const resolvePage = async (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue')
    const importPage = pages[`./Pages/${name}.vue`]

    const pageModule = await importPage()
    const page = pageModule.default

    if (page.layout !== undefined) return page


    if (name.startsWith('Landing')) {
        const {default: LandingLayout} = await import("./Shared/Landing/Layout.vue")
        page.layout = LandingLayout
    } else if (name.startsWith('Customer/Auth')) {
        const {default: AuthLayout} = await import("./Shared/Auth/Layout.vue")
        page.layout = AuthLayout
    } else if (name.startsWith('Customer')) {
        const {default: CustomerLayout} = await import("./Shared/Customer/Layout.vue")
        page.layout = CustomerLayout
    } else {
        const {default: AdminLayout} = await import("./Shared/Admin/Layout.vue")
        page.layout = AdminLayout
    }

    return page
}

createInertiaApp({
    resolve: name => resolvePage(name),
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
    progress: {delay: 250, color: '#29d', includeCSS: true, showSpinner: false}
})


