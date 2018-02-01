module.exports = function(grunt) {		
		
  // Project configuration.		
  grunt.initConfig({		
    pkg: grunt.file.readJSON('package.json'),		
		
    // Javascript Tasks		
    jshint: {		
      files: 'js/*.js',		
      options: {		
        // options here to override JSHint defaults		
        globals: {		
          jQuery: true,		
          console: true,		
          module: true,		
          document: true		
        }		
      }		
    },		
    uglify: {		
      options: {		
        banner: '/*\n <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> \n*/\n'		
      },		
      build: {		
        files: {		
          'js/scripts.min.js': 'js/*.js'		
        }		
      }		
    },		
    // CSS Tasks		
    sass: {		
      build: {		
        files: {		
          'style.css': 'sass/style.scss'		
        }		
      }		
    },		
    cssmin: {		
      build: {		
        files: {		
          'style.min.css': 'style.css'		
        }		
      }		
    },		
    autoprefixer: {		
      dist: {		
        files: {		
          'style.css': 'style.css'
        }		
      }		
    },		
    // General Tasks		
    watch: {		
      options: {		
        livereload: true,		
      },		
      livereload: {		
        files: ['**/*.php'],		
      },		
      // for stylesheets, watch css and scss files 		
      // run sass then autoprefixer and cssmin
      files: ['**/*.css', '**/*.scss'], 		
      tasks: ['sass', 'autoprefixer', 'cssmin'],		
		
      // for scripts, run jshint and uglify 		
      scripts: { 		
        files: '**/*.js',		
        tasks: ['jshint', 'uglify'] 		
      } 		
    }		
		
  });		
		
  // Load the plugin that provides the "uglify" task, etc.		
  grunt.loadNpmTasks('grunt-contrib-uglify');		
  grunt.loadNpmTasks('grunt-contrib-jshint');		
  grunt.loadNpmTasks('grunt-contrib-sass');		
  grunt.loadNpmTasks('grunt-autoprefixer');		
  grunt.loadNpmTasks('grunt-contrib-cssmin');		
  grunt.loadNpmTasks('grunt-contrib-watch');		
		
  // Default task(s).		
  grunt.registerTask('default', ['watch']);		
		
}; 