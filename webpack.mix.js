let mix = require('laravel-mix');

/**
mix.js('frontend/app.js', 'js')
  .autoload({
    jquery: ['$', 'window.jQuery']
  })
*/

mix.sass('frontend/app.scss', 'css')
  .setPublicPath('www');
