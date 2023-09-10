const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .babelConfig({
       plugins: [
           '@babel/plugin-transform-modules-commonjs' // Menambahkan plugin ini untuk mengaktifkan CommonJS
       ]
   })
   .vue();
