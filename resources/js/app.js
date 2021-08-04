import './bootstrap';
import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './src/routes/routes';
import App from './src/components/App';
import store from './src/store'

// Plugins
import GlobalComponents from "./src/components/global";
import Vuetify from './vendors/vuetify';
import i18n from './src/snippets';
import VueClipboards from 'vue-clipboards';
import VueChatScroll from 'vue-chat-scroll';

Vue.use(VueRouter);
Vue.use(GlobalComponents);
Vue.use(VueClipboards);
Vue.use(VueChatScroll);

Vue.config.productionTip = false;

new Vue({
    el: '#app',
    components: { App },
    router,
    store,
    i18n,
    Vuetify,
    render: (h) => h(App),
}).$mount('#app');
