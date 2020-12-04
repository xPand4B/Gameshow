import Vue from "vue";
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css';
// import 'material-design-icons-iconfont/dist/material-design-icons.css'
// import 'font-awesome/css/font-awesome.min.css'
import '@fortawesome/fontawesome-free/css/all.css'
// import { library } from '@fortawesome/fontawesome-svg-core'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// import { fas } from '@fortawesome/free-solid-svg-icons'
//
// Vue.component('font-awesome-icon', FontAwesomeIcon);
// library.add(fas);

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        // iconfont: 'mdiSvg',
        // iconfont: 'md',
        // iconfont: 'fa4',
        iconfont: 'fa',
        // iconfont: 'faSvg',
    },
    theme: {
        themes: {
            light: {
                primary: '#7E57C2',
            },
        }
    }
});
