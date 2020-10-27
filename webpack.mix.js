let mix = require('laravel-mix');

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
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/mail.scss', 'public/css');

var CopyWebpackPlugin = require('copy-webpack-plugin');
var UglifyJS = require('uglify-es');

if (mix.config.production) {
    mix.webpackConfig( webpack => {
        console.log("aca");
        return {
            plugins: [
                new CopyWebpackPlugin([
                    {
                        from: 'resources/assets/js/modules/',
                        to: '../public/js/',
                        transform (content, path) {
                            return Promise.resolve(Buffer.from(UglifyJS.minify(content.toString()).code, 'utf8'));
                        }
                    },
                ], 
                {
                    copyUnmodified: true
                })
            ]
        }
    });
} else {
    mix.copyDirectory('resources/assets/js/modules','public/js')
    mix.browserSync({
        proxy: 'http://defensa.test'
    });
}

































