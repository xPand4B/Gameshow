// Imports
import Vuetify from 'vuetify';
// Utilities
import { createLocalVue, mount } from '@vue/test-utils';

const localVue = createLocalVue();
localVue.use(Vuetify);
let vuetify;

export default {
    beforeEach() {
        return new Vuetify();
    },

    mountFunction(Component, options) {
        return mount(Component, {
            localVue,
            vuetify,
            ...options,
        });
    }
};
