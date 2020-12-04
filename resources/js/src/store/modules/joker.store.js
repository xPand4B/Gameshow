import ApiRoutes from './../../routes/apiRoutes';

export default {
    state: {
        jokers: null
    },

    getters: {
        getJokerAttributes({ game }) {
            return game.data.attributes;
        },
    },

    actions: {
        async fetchAllJokerData({ commit }) {
            try {
                const route = ApiRoutes.v1.joker.index;
                const { data } = await axios.get(route);

                commit('JOKER_FETCH_ALL', data);
            } catch(e) {}
        },
    },

    mutations: {
        JOKER_FETCH_ALL(state, payload) {
            state.jokers = payload;
        },
    }
};
