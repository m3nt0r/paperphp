'use strict';
var gulp = require('gulp');
var elixir = require('laravel-elixir');
elixir.config.assetsPath = 'frontend';
elixir.config.publicPath = 'public';

elixir.extend('release', function(name) {
  var paths = [
    'cache',
    'frontend/**',
    'pages/**',
    'public/.htaccess',
    'public/**',
    'src/**',
    'templates/**',
    'vendor/**',
    '.htaccess',
    'config.json.default',
    'package.json',
    'README.md'
  ];
  new elixir.Task('release', function(){
    var archiver = require('gulp-archiver');
    this.recordStep('Creating "paperphp.zip"');
    gulp.src(paths, { base: '.' })
      .pipe(archiver(name))
      .pipe(gulp.dest('./release/'));
  });
});

elixir(function(mix) {
  mix.browserify('paperphp.js');
  mix.sass('paperphp.scss');
  mix.release('paperphp.zip');
});

