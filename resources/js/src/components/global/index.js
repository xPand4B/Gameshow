// Components
import LanguageSwitch from './languageSwitch';

const GlobalComponents = {
    install(Vue) {
        Vue.component('language-switch', LanguageSwitch);
    }
};

export default GlobalComponents;
