import VueRouter from 'vue-router';
import Store from './../store';

/**
 * --------------------------------------------------------------------------
 * Resources:
 * --------------------------------------------------------------------------
 *
 * https://github.com/vuejs/vue-router/issues/2105
 */

function prefixRoutes(prefix = '', routes = []) {
    return routes.map((route) => {
        route.path = prefix + '' + route.path;
        return route;
    });
}

const routes = [
    {
        path: '/',
        component: () => import('../layouts/main'),
        children: [
            // Homepage
            {
                path: '',
                name: 'gameshow.home.index',
                component: () => import('./../pages/home'),
            },
            // Menu
            {
                path: ':id',
                name: 'gameshow.menu.index',
                component: () => import('./../pages/menu'),
                beforeEnter: (to, from, next) => {
                    Store.dispatch('fetchGameExists', to.params.id).then(() => {
                        const gameStore = Store.state.GameStore;

                        if (gameStore.gameExists === false) {
                            next({ name: 'gameshow.home.index' });
                        }

                        next();

                    }).catch(() => {
                        next({ name: 'gameshow.home.index' });
                    });
                }
            },
            // Questions
            {
                path: ':id/questions',
                name: 'gameshow.questions',
                component: () => import('./../pages/questions'),
                beforeEnter: (to, from, next) => {
                    Store.dispatch('fetchGameExists', to.params.id).then(() => {
                        const gameStore = Store.state.GameStore;

                        if (gameStore.gameExists === false) {
                            next({ name: 'gameshow.home.index' });
                        }

                        // if (!gameStore.isGamemaster) {
                        //     next({
                        //         name: 'gameshow.menu.index',
                        //         params: to.params
                        //     });
                        // }

                        next();

                    }).catch(() => {
                        next({ name: 'gameshow.home.index' });
                    });
                }
            },
            // Settings
            {
                path: ':id/settings',
                name: 'gameshow.settings',
                component: () => import('./../pages/settings'),
                beforeEnter: (to, from, next) => {
                    Store.dispatch('fetchGameExists', to.params.id).then(() => {
                        const gameStore = Store.state.GameStore;

                        if (gameStore.gameExists === false) {
                            next({ name: 'gameshow.home.index' });
                        }

                        next();

                    }).catch(() => {
                        next({ name: 'gameshow.home.index' });
                    });
                }
            },
        ]
    },

    // Page not found
    { path: '*', redirect: '/' },
];

export default new VueRouter({
    mode: 'history',
    routes
});
