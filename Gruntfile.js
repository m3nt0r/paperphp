module.exports = function(grunt) {
  'use strict';

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    concat: {
      options: {
        stripBanners: true,
        process: function (src, filepath) {
          return '\n\n// Source: ' + filepath + '\n\n' + src;
        },
      },
      js_libs: {
        nonull: true,
        src: [
          'node_modules/underscore/underscore-min.js',
          'node_modules/jquery/dist/jquery.min.js'
        ],
        dest: 'public/js/vendor.js',
      }
    },

    browserify: {
      dist: {
        files: {
          'public/js/paperphp.js': [
            'frontend/js/**/*.js'
          ]
        },
        options: {}
      }
    },

    less: {
      custom: {
        options: {
          plugins: [
            new (require('less-plugin-autoprefix'))({browsers: ['last 3 versions']}),
            new (require('less-plugin-clean-css'))()
          ]
        },
        files: {
          'public/css/paperphp.css': 'frontend/less/paperphp.less'
        }
      }
    },

    watch: {
      js: {
        files: ['frontend/js/**/*.js'],
        tasks: ['browserify']
      },
      css: {
        files: ['frontend/less/**/*.less'],
        tasks: ['less']
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-browserify');

  grunt.registerTask('build', ['concat', 'less', 'browserify']);
  grunt.registerTask('default', ['watch']);

};