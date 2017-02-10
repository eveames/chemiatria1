const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

var elixirTypscript = require('laravel-elixir-typescript');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
       .webpack('app.js');
    mix.copy('node_modules/@angular', 'public/@angular');
    mix.copy('node_modules/rxjs', 'public/rxjs');
    mix.copy('node_modules/systemjs', 'public/systemjs');
    mix.copy('node_modules/es6-promise', 'public/es6-promise');
    mix.copy('node_modules/es6-shim', 'public/es6-shim');
    mix.copy('node_modules/zone.js', 'public/zone.js');
 
    mix.typescript('app.js','public/js','/**/*.ts',{
                  "target": "ES5",
                  "module": "system",
                  "moduleResolution": "node",
                  "sourceMap": true,
                  "emitDecoratorMetadata": true,
                  "experimentalDecorators": true,
                  "removeComments": false,
                  "noImplicitAny": false,
    });
});
