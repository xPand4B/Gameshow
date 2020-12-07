import ApiRoutes from './../../routes/apiRoutes';

export default {
    state: {
        success: false,
        playerName: null
    },

    getters: {
        getPlayerName({ playerName }) {
            return playerName;
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

        setPlayerName({ commit }, playerName) {
            commit('PLAYER_SET', {
                playerName,
                success: true
            });
        },
    },

    mutations: {
        PLAYER_SET(state, payload) {
            state.playerName = payload.playerName;
            state.success = !!payload.success;
        }
    },
};
