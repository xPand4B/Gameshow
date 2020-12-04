import ApiRoutes from './../../routes/apiRoutes';

const LOCAL_STORAGE_PLAYER_NAME = 'playerName';

export default {
    state: {
        playerName: null
    },

    getters: {
        hasPlayerNameSet() {
            return !!localStorage.getItem(LOCAL_STORAGE_PLAYER_NAME);
        },

        getCurrentPlayerName() {
            return localStorage.getItem(LOCAL_STORAGE_PLAYER_NAME);
        }
    },

    actions: {
        async setPlayerName({ commit }, username) {
            const route = ApiRoutes.v1.auth.login;

            await axios.post(route, { username }).then(() => {
                commit('SET_PLAYER_NAME', username);
            });
        },

        unsetPlayerName({ commit }) {
            commit('UNSET_PLAYER_NAME');
        },
    },

    mutations: {
        SET_PLAYER_NAME(state, payload) {
            state.playerName = payload;
            localStorage.setItem(LOCAL_STORAGE_PLAYER_NAME, payload);
        },

        UNSET_PLAYER_NAME(state) {
            state.playerName = null;
            localStorage.removeItem(LOCAL_STORAGE_PLAYER_NAME);
        }
    },
};
