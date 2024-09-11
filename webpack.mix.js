const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        //
    ])
    .styles(
        [
            "resources/css/vendor/ladda.min.css", // Path ke file yang diunduh manual
        ],
        "public/css/ladda.css"
    )
    .scripts(
        [
            "resources/js/vendor/ladda.min.js", // Path ke file yang diunduh manual
        ],
        "public/js/ladda.js"
    );

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .copy(
        "node_modules/toastr/build/toastr.min.css",
        "public/css/toastr.min.css"
    )
    .copy("node_modules/toastr/build/toastr.min.js", "public/js/toastr.min.js");
