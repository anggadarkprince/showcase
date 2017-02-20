var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

// syntax ECMAscript 2015
elixir((mix) => {
    mix.sass('app.scss')
       .webpack('app.js');
});

elixir(function(mix) {
    // compile and combine admin (+css) sass files
    mix.sass(['admin.scss', '../css/simple-sidebar.css'], 'public/css/admin.css');

    // combine plain css
    mix.styles(['helper.css','misc.css'], 'public/css/support.css');

    // combine scripts
    mix.scripts(['scrollto.js', 'functions.js'], 'public/js/functions.js');

    // copy file
    mix.copy('resources/assets/js/fontloader.js', 'public/js/fontloader.js');

    // Versioning with hash like styles-a322t45.css
    mix.version(['css/app.css', 'css/support.css', 'css/admin.css',
        'js/app.js', 'js/functions.js', 'js/fontloader.js']);

    // Auto refresh when run gulp watch
    mix.browserSync({
        proxy: 'laravel.dev:8080'
    });
});
