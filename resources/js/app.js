import './bootstrap';
import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './src/routes/routes';
import App from './src/components/App';
import store from './src/store'

// Plugins
import GlobalComponents from "./src/components/global";
import vuetify from './vendors/vuetify';
import i18n from './src/snippets';
import VueClipboards from 'vue-clipboards';

Vue.use(VueRouter);
Vue.use(GlobalComponents);
Vue.use(VueClipboards);

Vue.config.productionTip = false;

new Vue({
    el: '#app',
    components: { App },
    router,
    store,
    i18n,
    vuetify,
    render: (h) => h(App),
}).$mount('#app');
