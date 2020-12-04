import i18n from './../../snippets/index';

export default {
    state: {
        lobby: [],
    },

    getters: {
        getLobbyUser({ lobby }) {
            return lobby;
        }
    },

    actions: {
        lobbyInit({ commit }, users) {
            commit('LOBBY_INIT', users);
        },

        lobbyJoined({ commit }, user) {
            commit('LOBBY_JOINED', user);

            Toast.fire({
                icon: 'info',
                title: i18n.t('lobby.joined', { name: user.playerName}),
            });
        },

        lobbyLeft({ commit }, user) {
            commit('LOBBY_LEFT', user);

            Toast.fire({
                icon: 'info',
                title: i18n.t('lobby.left', { name: user.playerName}),
            });
        }
    },

    mutations: {
        LOBBY_INIT(state, payload) {
            payload.map((user) => {
                state.lobby.push({
                    text: user.playerName,
                    isGamemaster: user['is_gamemaster']
                });
            });
        },

        LOBBY_JOINED(state, payload) {
            state.lobby.push({
                text: payload.playerName,
                isGamemaster: payload['is_gamemaster']
            });
        },

        LOBBY_LEFT(state, payload) {
            state.lobby.map((user, index) => {
                if (user.text === payload.playerName) {
                    state.lobby.splice(index, 1);
                }
            });
        },
    },
};
