const {mix} = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .scripts([
            'resources/assets/js/vendor/typeahead.bundle.js',
            'resources/assets/js/scrollto.js',
            'resources/assets/js/functions.js',
            'resources/assets/js/scripts.js',
            'resources/assets/js/pushmessages.js'
        ], 'public/js/functions.js')

    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css/admin.css')
    .styles(['helper.css', 'misc.css'], 'public/css/support.css')
    .options({
        postCss: [
            require('autoprefixer')()
        ]
    })

    .copy('resources/assets/js/fontloader.js', 'public/js/fontloader.js')
    .copy('resources/assets/img/', 'public/img/', false)

    .extract(['vue', 'lodash', 'jquery', 'axios', 'laravel-echo'])
    .sourceMaps()
    .version();

if (mix.config.inProduction) {
    mix.version();
}

mix.browserSync({
    proxy: 'laravel.dev:8080',
    open: false
});