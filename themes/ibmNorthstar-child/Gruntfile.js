(function () {
  'use strict';
  module.exports = function (grunt) {
    grunt.initConfig({
      directory: '', // Leave blank for current directory, otherwise make sure to include trailing slash.
      concat: {
        options: {
          separator: '\n\n',
          banner: '/*! Last edited: <%= grunt.template.today("yyyy-mm-dd") %> */\n /* DO NOT EDIT THIS FILE DIRECTLY */\n\n'
        },
        js_site: {
          src: '<%= directory %>assets/js/src/*.js',
          dest: '<%= directory %>assets/js/site.js'
        }
      },
      less: {
        development: {
          options: {
            paths: ['<%= directory %>assets/css'],
            sourceMap: true
          },
          files: {
            '<%= directory %>assets/css/style.css': '<%= directory %>assets/css/src/__bootstrap.less'
          }
        }
      },
      cssmin: {
        minify: {
          src: ['<%= directory %>assets/css/style.css'],
          dest: '<%= directory %>assets/css/style.min.css'
        }
      },
      uglify: {
        options: {
          mangle: false,
          compress: {
            drop_console: false
          }
        },
        my_target: {
          files: {
            '<%= directory %>assets/js/site.min.js': '<%= directory %>assets/js/site.js'
          }
        }
      },
      watch: {
        css: {
          files: ['<%= directory %>assets/css/src/*.less', '<%= directory %>assets/css/src/*/*.less'],
          tasks: ['less', 'cssmin']
        },
        js: {
          files: ['<%= directory %>assets/js/*/*.js'],
          tasks: ['concat', 'uglify'] //, 'uglify'
        }
      }
    });
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.registerTask('default', ['less', 'cssmin', 'watch']);
  };
})();
