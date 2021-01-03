export default {
    v1: {
        auth: {
            login: 'api/v1/auth/login',
            me:    'api/v1/auth/me',
        },
        game: {
            index:   'api/v1/game',
            create:  'api/v1/game',
            show:    'api/v1/game/gameID',
            exists:  'api/v1/game/gameID/exists',
            update:  'api/v1/game/gameID',
            destroy: 'api/v1/game/gameID',
        },
        questions: {
            index:      'api/v1/game/gameID/questions',
            store:      'api/v1/game/gameID/questions/add',
            show:       'api/v1/game/gameID/questions/questionID',
            update:     'api/v1/game/gameID/questions/questionID',
            destroy:    'api/v1/game/gameID/questions/questionID',
        },
        answer: {
            store:      'api/v1/game/gameID/questions/questionID/add',
            destroy:    'api/v1/game/gameID/questions/questionID/answerID',
        },
        lobby: {
            join: 'api/v1/lobby/id/join',
        },
        joker: {
            index: 'api/v1/joker',
            show:  'api/v1/joker/id',
        }
    }
};
