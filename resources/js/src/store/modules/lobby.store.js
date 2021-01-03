import i18n from './../../snippets/index';
import Store from './../index';

export default {
    state: {
        lobby: [],
        chat: [],
        joined: false,
    },

    getters: {
        getLobbyUser({ lobby }) {
            return lobby;
        },

        getChatMessages({ chat }) {
            return chat;
        },

        getJoinedSuccessfully({ joined }) {
            return joined;
        },

        getLobbyFull({ lobby }) {
            return lobby.length - 1 > Store.getters.getCurrentGamePlayerCount;
        }
    },

    actions: {
        lobbyInit({ commit }, users) {
            commit('LOBBY_INIT', users);

            Toast.fire({
                icon: 'success',
                title: i18n.t('lobby.init'),
            });
        },

        lobbyJoined({ commit }, user) {
            commit('LOBBY_JOINED', user);

            Toast.fire({
                icon: 'info',
                title: i18n.t('lobby.joined', { name: user.playerName }),
            });
        },

        lobbyLeft({ commit }, user) {
            commit('LOBBY_LEFT', user);

            Toast.fire({
                icon: 'warning',
                title: i18n.t('lobby.left', { name: user.playerName }),
            });
        },

        pushChatMessage({ commit }, data) {
            commit('CHAT_MESSAGE_SENT', data);
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

            state.joined = true;
        },

        LOBBY_JOINED(state, payload) {
            let userAlreadyThere = false;
            state.lobby.some((user, index) => {
                if (user.text === payload.playerName) {
                    userAlreadyThere = true;
                    return true;
                }
            });

            if (! userAlreadyThere) {
                state.lobby.push({
                    text: payload.playerName,
                    isGamemaster: payload['is_gamemaster']
                });
            }
        },

        LOBBY_LEFT(state, payload) {
            state.lobby.map((user, index) => {
                if (user.text === payload.playerName) {
                    state.lobby.splice(index, 1);
                }
            });
        },

        CHAT_MESSAGE_SENT(state, payload) {
            state.chat.push(payload);
        }
    },
};
