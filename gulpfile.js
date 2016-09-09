'use strict';

var elixir = require('laravel-elixir');
elixir.config.assetsPath = 'frontend';
elixir.config.publicPath = 'public';

elixir(function(mix) {

  mix.browserify('paperphp.js');
  
  mix.sass('paperphp.scss');
  
});