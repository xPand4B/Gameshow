import ApiRoutes from './../../routes/apiRoutes';

export default {
    state: {
        success: false,
        id: null,
        playerName: null
    },

    getters: {
        getPlayerName({ playerName }) {
            return playerName;
        },

        getPlayerId({ id }) {
            return id;
        },

        getPlayerLoginSuccess({ success }) {
            return success;
        }
    },

    actions: {
        async loginPlayer({ commit }, username) {
            await axios.post(ApiRoutes.v1.auth.login, {
                username
            }).then(response => {
                commit('PLAYER_SET', response.data);
            }).catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: error
                });
            });
        },

        setPlayerName({ commit }, payload) {
            commit('PLAYER_SET', payload);
        },
    },

    mutations: {
        PLAYER_SET(state, payload) {
            state.id         = payload.id;
            state.playerName = payload.playerName;
            state.success    = !!payload.success;
        }
    },
};
