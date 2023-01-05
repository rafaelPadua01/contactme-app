import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import App from './App.vue'
import VueTheMask from 'vue-the-mask';

//import { createInertiaApp } from '@inertiajs/inertia-vue3';
//import { InertiaProgress } from '@inertiajs/progress';
//import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
//import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import '@mdi/font/css/materialdesignicons.css'


// Router
import router from './Router'

//const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const vuetify = createVuetify({
    components,
    directives,
    icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    }
  },
    
  })
  
  createApp(App)
    .use(vuetify)
    .use(router)
    .use(VueTheMask)
    .mount('#app');
  
//createInertiaApp({
//    title: (title) => `${title} - ${appName}`,
//    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//    setup({ el, app, props, plugin }) {
//        return createApp({ render: () => h(app, props) })
//            .use(plugin)
//            .use(ZiggyVue, Ziggy)
//            .mount(el);
//    },
//});
//
//InertiaProgress.init({ color: '#4B5563' });
