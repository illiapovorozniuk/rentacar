const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js(["resources/js/admin/admin.js"], "public/js")
    .sass("resources/sass/admin/admin.scss", "public/css")
    .vue();

if (mix.inProduction()) {
  mix.version();
}

let sassFrontPath = "resources/sass/front/";
let cssOutputPath = "public/css/front/";
mix
    .js(`resources/js/front.js`, `public/js/front.js`)
    .sass(`${sassFrontPath}index.scss`, `${cssOutputPath}index.css`)
    .sass(`${sassFrontPath}login.scss`, `${cssOutputPath}login.css`)
    .sass(`${sassFrontPath}register.scss`, `${cssOutputPath}register.css`)
    .sass(`${sassFrontPath}car.scss`, `${cssOutputPath}car.css`)
    .sass(`${sassFrontPath}plp.scss`, `${cssOutputPath}plp.css`)
    .sass(`${sassFrontPath}plp_without_cars.scss`, `${cssOutputPath}plp_without_cars.css`);
