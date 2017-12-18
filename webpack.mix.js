let mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');

mix.js('src/js/app.js', 'public/js');
mix.sass('src/sass/app.scss', 'public/css');
mix.copyDirectory('src/libs', 'public/libs');
mix.copyDirectory('src/img', 'public/img');

if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new CompressionPlugin({
                asset: '[path]',
                algorithm: 'gzip',
                test: /\.js$|\.css$/,
                threshold: 10240,
                minRatio: 0.8
            }),
        ]
    });

    mix.version();
}