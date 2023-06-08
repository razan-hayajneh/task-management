require('./bootstrap');


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import * as icons from '@element-plus/icons';
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
library.add(faUserSecret)
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas);
import { fab } from '@fortawesome/free-brands-svg-icons';
library.add(fab);
import { far } from '@fortawesome/free-regular-svg-icons';
library.add(far);
import CountryFlag from 'vue-country-flag-next'
import { Lang } from 'laravel-vue-lang';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueSweetalert2 from 'vue-sweetalert2';
// import VueRouter from 'vue-router';
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'TaskManagement';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),

    setup({ el, app, props, plugin }) {
        return createApp({ el: '#app',render: () => h(app, props) })
            .use(plugin)
            .use(ElementPlus)
            .use(icons)
            .use(CountryFlag)
            .use(VueSweetalert2)
            .use(Lang)
            .use(VueAxios, axios)
            .component('font-awesome-icon', FontAwesomeIcon)
            .component('Link', Link)
            .component('Head', Head)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
