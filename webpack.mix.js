let mix = require('laravel-mix');

mix.js('frontend/app.js', 'js')
  .sass('frontend/app.scss', 'css')
  .setPublicPath('www');
