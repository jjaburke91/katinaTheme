/**
 * A lot of tips on this found here: http://g00glen00b.be/angular-grunt/
 *
 * @param grunt
 */

module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        /* Info on wiredep found here: https://github.com/stephenplusplus/grunt-wiredep
        *  Needed to override script field so that it includes the php to retrieve template directory */
        wiredep: {
            task: {
                src: ['index.php'],
                options: {
                    fileTypes: {
                        html: {
                            replace: {
                                js: '<script type="text/javascript" src="<?php bloginfo(\'template_directory\'); ?>/{{filePath}}"></script>',
                                css:'<link rel="stylesheet" href="<?php bloginfo(\'template_directory\'); ?>/{{filePath}}" />'
                            }
                        }
                    }
                }
            }
        },

        sass: {
            dist: {
                options: {
                    sourcemap: 'none',
                    style: 'compressed'
                },
                files: {
                    'style.css': 'style/main.sass'
                }
            }
        },

        // installs all bower dependencies to /lib
        bower: {
            install: {
                options: {
                    install: true,
                    copy: false,
                    targetDir: './libs',
                    cleanTargetDir: true
                }
            }
        },

        // Converts all the views to a js file
        html2js: {
            dist: {
                src: [ 'angular/views/*.html', 'angular/directives/**/*.html'],
                dest: 'tmp/views.js'
            }
        },

        // Concatenates all angular files and views
        concat: {
            options: {
                separator: ';'
            },
            dist: {
                src: [ 'angular/*.js',
                    'angular/controllers/*.js',
                    'angular/directives/**/*.js',
                    'tmp/*.js' ],
                dest: 'dist/app.js'
            }
        },

        // Minifys the concatenated js file
        uglify: {
            dist: {
                files: {
                    'dist/app.min.js': [ 'dist/app.js' ]
                },
                options: {
                    mangle: false
                }
            }
        },

        // cleans the tmp directory
        clean: {
            temp: {
                src: [ 'tmp']
            },
            prod: {
                src: ['tmp', 'dist/app.js']
            }
        },

        watch: {
            dev: {
                files: [ 'Gruntfile.js',
                    'style/*.sass',
                    'angular/*.js',
                    'angular/controllers/*.js',
                    'angular/directives/**/*.js', 'angular/directives/**/*.html',
                    '**/.html', 'angular/**/*.html', '*.html'
                ],
                tasks: [ 'html2js:dist', 'sass', 'concat:dist', 'clean:temp' ],
                options: {
                    atBegin: true
                }
            },
            min: {
                files: [ 'Gruntfile.js',
                    'style/*.sass',
                    'angular/*.js',
                    'angular/controllers/*.js',
                    'angular/directives/**/*.js', 'angular/directives/**/*.html',
                    '**/.html', '*.html'
                ],
                tasks: [ 'html2js:dist', 'sass', 'concat:dist', 'clean:temp', 'uglify:dist' ],
                options: {
                    atBegin: true
                }
            }
        }

    });

    // Loads order of tasks
    grunt.loadNpmTasks('grunt-wiredep');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-html2js');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-bower-task');
    grunt.loadNpmTasks('grunt-contrib-sass');

    grunt.registerTask('dev', [ 'bower', 'sass', 'watch:dev' ]);
    grunt.registerTask('test', [ 'bower' ]);
    grunt.registerTask('minified', [ 'bower', 'watch:min' ]);
    grunt.registerTask('package', [ 'bower', 'sass', 'html2js:dist', 'concat:dist', 'uglify:dist', 'clean:prod' ]);

};
