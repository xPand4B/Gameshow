export default {
    v1: {
        auth: {
            login: 'api/v1/auth/login',
            me:    'api/v1/auth/me',
        },
        game: {
            index:   'api/v1/game',
            create:  'api/v1/game',
            show:    'api/v1/game/id',
            exists:  'api/v1/game/id/exists',
            update:  'api/v1/game/id',
            destroy: 'api/v1/game/id',
        },
        questions: {
            store:   'api/v1/game/id/questions',
            show:    'api/v1/game/id/questions',
            update:  'api/v1/game/id/questions',
            destroy: 'api/v1/game/id/questions',
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
