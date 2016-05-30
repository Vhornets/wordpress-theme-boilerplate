module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bower: 'bower_components',

        less: {
            options: {
                includePaths: ['<%= bower %>/less/bootstrap'],
                sourceMap: true,
                sourceMapURL: '../css/app.min.css.map',
                // compress: true
            },
            dist: {
                files: {
                    'css/app.min.css': 'less/app.less'
                }
            }
        },

        uglify: {
            dist: {
                files: {
                    'js/app.min.js': [
                        '<%= bower %>/jquery/jquery.min.js',
                        '<%= bower %>/bootstrap/dist/js/bootstrap.min.js',
                        '<%= bower %>/slick-carousel/slick/slick.min.js',
                        '<%= bower %>/jquery-validate/dist/jquery.validate.min.js',
                        '<%= bower %>/scroll-reveal/dist/scrollReveal.min.js',
                        '<%= bower %>/magnific-popup/dist/jquery.magnific-popup.min.js',
                        '<%= bower %>/jquery.maskedinput/dist/jquery.maskedinput.min.js',
                        'js/settings.js',
                        'js/app.js',
                        'js/main.js'
                    ]
                }
            }
        },

        sprite: {
            all: {
                src: 'img/sprite-source/*.png',
                dest: 'img/sprite_' + new Date().getTime() + '.png',
                destCss: 'less/sprite.less',
                padding: 5,
                algorithm: 'binary-tree'
            }
        },

        watch: {
            grunt: {
                files: ['Gruntfile.js']
            },

            less: {
                files: 'less/*.less',
                tasks: ['less']
            },

            options: {
                spawn: false
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-spritesmith');
    grunt.loadNpmTasks('grunt-notify');

    grunt.registerTask('build', ['less', 'uglify']);
    grunt.registerTask('default', ['build', 'watch']);
};