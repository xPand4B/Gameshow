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
});

if (mix.inProduction()) {
    mix.version();
    mix.sourceMaps();
}

mix.webpackConfig({
    output: {
        chunkFilename: mix.inProduction() ? "js/chunks/[name].[chunkhash].js" : "js/chunks/[name].js",
        publicPath: '',
    }
})

/**
 * --------------------------------------------------------------------------
 * | Application
 * --------------------------------------------------------------------------
 */
mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false
    });

/**
 * --------------------------------------------------------------------------
 * | Vendors
 * --------------------------------------------------------------------------
 */
mix
    .js('resources/js/vendors/vue.js', 'public/js')
    .js('resources/js/vendors/vuetify.js', 'public/js')
    .js('resources/js/vendors/sweetalert.js', 'public/js')

/**
 * --------------------------------------------------------------------------
 * | Assets
 * --------------------------------------------------------------------------
 */
mix
    // Resource Assets
    .copyDirectory('resources/assets/', 'public/')

/**
 * --------------------------------------------------------------------------
 * | Extract Vendors
 * --------------------------------------------------------------------------
 */
// mix.extract();
