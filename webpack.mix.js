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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/editor/simplemde-1.11.2/js/simplemde.js', 'public/js/simplemde.js')
    .copyDirectory('resources/editor/simplemde-1.11.2/css', 'public/css')
    .version()
    .copyDirectory('resources/editor/simditor-2.3.28/js', 'public/js')
    .copyDirectory('resources/editor/simditor-2.3.28/css', 'public/css');
