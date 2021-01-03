import VueRouter from './../../routes/routes';
import ApiRoutes from './../../routes/apiRoutes';
import i18n from './../../snippets/index';

const REDIRECT_AFTER_CREATE = 'gameshow.menu.index';

export default {
    state: {
        currentGame: null,
        gameExists: false,
        isGamemaster: false,
    },

    getters: {
        getCurrentGameAttributes({ currentGame }) {
            if (currentGame) {
                return currentGame.data.attributes;
            }
        },

        getCurrentGameId({ currentGame }) {
            if (currentGame) {
                return currentGame.data.id;
            }
        },

        getGameExists({ gameExists }) {
            return gameExists;
        },

        isGamemaster({ isGamemaster }) {
            return isGamemaster;
        },

        getCurrentGamePlayerCount({ currentGame }) {
            if (currentGame) {
                return currentGame.data.attributes['player_count'];
            }
        },

        getGameJoker({ currentGame }) {
            if (!currentGame) {
                return;
            }

            const baseSnippetPath = 'gameplay.availableJoker';
            const jokers = {};

            currentGame.data.attributes['available_joker'].map(joker => {
                const attrs = joker.attributes;
                const name = `${baseSnippetPath}.${attrs.name}`;

                jokers[joker.id] = {
                    id: joker.id,
                    name: attrs.name,
                    value: attrs.active,
                    count: attrs.count,
                    label: i18n.t(`${name}.label`),
                    hint: i18n.t(`${name}.hint`),
                };
            });

            return jokers;
        },

        getGamePointSettings({ currentGame }) {
            if (!currentGame) {
                return;
            }

            const attrs = currentGame.data.attributes;

            return {
                correctAnswer: attrs['correct_points'],
                wrongAnswer: attrs['wrong_points'],
                pointsForPlayersIfWrongAnswer: !!attrs['points_if_wrong_answer'],
            }
        },
    },

    actions: {
        async createNewGame({ state, commit }, formData) {
            const route = ApiRoutes.v1.game.create;

            await axios.post(route, formData).then(response => {
                commit('GAME_CREATE', response.data);

                return VueRouter.push({
                    name: REDIRECT_AFTER_CREATE,
                    params: {
                        id: state.currentGame.data.id
                    }
                });
            }).catch(e => {
                const error = Object.assign({}, e);
                let message = '';
                for (const [key, value] of Object.entries(error.response.data.errors)) {
                    message += `- ${value}<br>`;
                }

                Swal.fire({
                    icon: 'error',
                    title: error.response.data.message,
                    html: message
                });
            });
        },

        async fetchSingleGameData({ state, commit }, gameId) {
            if (state.currentGame !== null) {
                return;
            }

            const route = ApiRoutes.v1.game.show
                .replace('gameID', gameId);

            await axios.get(route).then(response => {
                commit('GAME_FETCH_CURRENT', response.data);

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },

        async fetchGameExists({ state, commit }, gameId) {
            if (state.currentGame !== null) {
                return;
            }

            const route = ApiRoutes.v1.game.exists
                .replace('gameID', gameId);

            await axios.get(route).then(response => {
                commit('GAME_SET_EXISTS', response.data);

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },

        async updateGameSettings({ state, commit }, payload) {
            try {
                const route = ApiRoutes.v1.game.update
                    .replace('gameID', state.currentGame.data.id);

                const { data } = await axios.patch(route, payload);

                commit('GAME_UPDATE_FIELD', data);
            } catch (e) {
                await Toast.fire({
                    icon: 'error',
                    title: e
                });
            }
        },

        async formatPusherData({ commit }, payload) {
            try {
                await commit('GAME_UPDATE_PUSHER', payload);
            } catch(e) {
                await Toast.fire({
                    icon: 'error',
                    title: e
                });
            }
        },
    },

    mutations: {
        GAME_CREATE(state, payload) {
            state.currentGame  = payload;
            state.gameExists   = true;
            state.isGamemaster = true;
        },

        GAME_FETCH_CURRENT(state, payload) {
            state.currentGame = payload;
            state.isGamemaster = payload.data.attributes['is_gamemaster'];
        },

        GAME_SET_EXISTS(state, payload) {
            state.gameExists   = payload.success;
            state.isGamemaster = payload['is_gamemaster'];
        },

        GAME_UPDATE_FIELD(state, payload) {
            state.currentGame = payload;
        },

        GAME_UPDATE_PUSHER(state, payload) {
            state.currentGame.data = payload;
        },
    }
};
