let mix = require('laravel-mix');

mix.js('src/js/app.js', 'public/js');
mix.sass('src/sass/app.scss', 'public/css');
mix.copyDirectory('src/libs', 'public/libs');
mix.copyDirectory('src/img', 'public/img');
