const mix = require('laravel-mix');
let autoprefixer = require('autoprefixer')

require('dotenv').config();

mix.setResourceRoot('../');
mix.setPublicPath('public/themes/wordplate/assets');

mix.options({
    postCss: [
        require('autoprefixer')({
            grid: true,
            browsers: ['last 2 versions', 'IE 7', 'Safari 9']
        })
    ]
});

mix.js('resources/assets/scripts/app.js', 'scripts');
mix.sass('resources/assets/styles/app.scss', 'styles');
mix.sass('resources/assets/styles/admin.scss', 'styles');
mix.styles([
    'node_modules/alertifyjs/build/css/alertify.min.css',
    'public/themes/wordplate/assets/styles/app.css'
], 'public/themes/wordplate/assets/styles/main.css');

mix.version();
