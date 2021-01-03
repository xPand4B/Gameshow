import ApiRoutes from "../../routes/apiRoutes";

export default {
    state: {
        questions: [],
    },

    getters: {
        getGameQuestions({ questions }) {
            return questions;
        },

        getGameQuestionsFormatted({ questions }) {
            return questions.data.attributes.map(item => {
                return item.attributes;
            });
        },
    },

    actions: {
        async fetchQuestions({ commit }, gameId) {
            const route = ApiRoutes.v1.questions.index
                .replace('gameID', gameId);

            await axios.get(route).then(response => {
                commit('QUESTIONS_FETCH', response.data);

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },

        async addQuestion({ commit }, gameId) {
            const route = ApiRoutes.v1.questions.store
                .replace('gameID', gameId);

            await axios.get(route).then(response => {
                commit('QUESTIONS_ADD', response.data);

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },

        async deleteQuestion({ commit }, data) {
            const {
                gameId, questionId, index
            } = data;

            const route = ApiRoutes.v1.questions.destroy
                .replace('gameID', gameId)
                .replace('questionID', questionId);

            await axios.delete(route, data).then(() => {
                commit('QUESTIONS_DELETE', index);

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },

        async addAnswerOption({ commit }, data) {
            const {
                gameId, questionId, index
            } = data;

            const route = ApiRoutes.v1.answer.store
                .replace('gameID', gameId)
                .replace('questionID', questionId);

            await axios.get(route).then(response => {
                commit('ANSWER_ADD', {
                    response: response.data,
                    index
                });

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },

        async deleteAnswerOption({ commit }, data) {
            const {
                gameId, questionId, answerId
            } = data;

            const route = ApiRoutes.v1.answer.destroy
                .replace('gameID', gameId)
                .replace('questionID', questionId)
                .replace('answerID', answerId)

            await axios.delete(route).then(() => {
                commit('ANSWER_DELETE', data);

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },

        async updateQuestions({ commit }, data) {
            const {
                gameId, questionId, payload
            } = data;

            const route = ApiRoutes.v1.questions.update
                .replace('gameID', gameId)
                .replace('questionID', questionId);

            await axios.patch(route, payload).then((response) => {
                commit('QUESTIONS_UPDATE', response.data);

            }).catch(e => {
                const error = Object.assign({}, e);

                Toast.fire({
                    icon: 'error',
                    title: error.response.data.errors[0].detail
                });
            });
        },
    },

    mutations: {
        QUESTIONS_FETCH(state, payload) {
            state.questions = [];
            state.questions = payload;
        },

        QUESTIONS_ADD(state, payload) {
            state.questions.data.attributes.push(
                payload.data
            );
        },

        QUESTIONS_DELETE(state, index) {
            state.questions.data.attributes.splice(index, 1);
        },

        QUESTIONS_UPDATE(state, payload) {
            //
        },

        ANSWER_ADD(state, payload) {
            const {
                response, index
            } = payload;

            state.questions.data.attributes[index].attributes = response.data.attributes;
        },

        ANSWER_DELETE(state, payload) {
            const {
                index, answerId
            } = payload;

            state.questions.data.attributes[index].attributes.answers.some((answer, loopIndex) => {
                if (answer.id === answerId) {
                    state.questions.data.attributes[index].attributes.answers.splice(loopIndex, 1);
                    return true;
                }
            });
        },
    },
};
