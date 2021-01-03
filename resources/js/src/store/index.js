import Vue from 'vue';
import Vuex from 'vuex';
import LobbyStore from './modules/lobby.store';
import GameStore from './modules/game.store';
import PlayerStore from './modules/player.store';
import QuestionStore from './modules/question.store';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        LobbyStore,
        GameStore,
        PlayerStore,
        QuestionStore,
    },

    state: {
        //
    },

    getters: {
        //
    },

    actions: {
        //
    },

    mutations: {
        //
    },
});
