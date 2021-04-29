const mix = require('laravel-mix');

mix.js('public/src/js/app.js', 'public/js')
    .sass('public/src/sass/app.scss', 'public/css')
    .sourceMaps();
