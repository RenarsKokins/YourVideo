const mix = require('laravel-mix');

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
mix.copy('node_modules/popper.js/dist/popper.js.map', 'public/js/popper.js.map');
mix.copy('node_modules/video.js/dist/video.min.js', 'public/js/video.min.js');
mix.copy('node_modules/videojs-hls-quality-selector/dist/videojs-hls-quality-selector.min.js', 'public/js/videojs-hls-quality-selector.min.js');
mix.copy('node_modules/videojs-contrib-quality-levels/dist/videojs-contrib-quality-levels.min.js', 'public/js/videojs-contrib-quality-levels.min.js');
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
