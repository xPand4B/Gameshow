const mix = require('laravel-mix');

/**
 * --------------------------------------------------------------------------
 * | Configuration Stuff
 * --------------------------------------------------------------------------
 */
mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@':
                __dirname + '/resources/js',
            '@components':
                __dirname + '/resources/js/src/components'
        },
    },
    output: {
        publicPath: '',
        chunkFilename: mix.inProduction() ? "js/chunks/[name].[chunkhash].js" : "js/chunks/[name].js",
    }
});

if (mix.inProduction()) {
    mix.version();
    mix.sourceMaps();
}

/**
 * --------------------------------------------------------------------------
 * | Application
 * --------------------------------------------------------------------------
 */
mix.js('resources/js/app.js', 'public/js')
    .vue({ version: 2 })
    .sass('resources/scss/app.scss', 'public/css')
    .options({
        processCssUrls: false
    });

/**
 * --------------------------------------------------------------------------
 * | Vendors
 * --------------------------------------------------------------------------
 */
mix.js('resources/js/vendors/vue.js', 'public/js')
    .js('resources/js/vendors/vuetify.js', 'public/js')
    .js('resources/js/vendors/sweetalert.js', 'public/js');

/**
 * --------------------------------------------------------------------------
 * | Extract Vendors
 * --------------------------------------------------------------------------
 */
// mix.extract();
