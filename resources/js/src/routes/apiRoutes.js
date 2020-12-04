export default {
    v1: {
        auth: {
            login: '/api/v1/login'
        },
        game: {
            index:      '/api/v1/game',
            create:     '/api/v1/game',
            show:       '/api/v1/game/id',
            update:     '/api/v1/game/id',
            destroy:    '/api/v1/game/id',
        },
        lobby: {
            join: '/api/v1/lobby/id/join',
        },
        joker: {
            index:  '/api/v1/joker',
            show:   '/api/v1/joker/id',
        }
    }
};
