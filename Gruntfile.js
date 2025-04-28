module.exports = function(grunt) {
    grunt.initConfig({
        uglify: {
            options: {
                mangle: true,
                compress: true,
                sourceMap: true
            },
            amd: {
                files: [{
                    expand: true,
                    cwd: 'amd/src',     
                    src: ['*.js'],    
                    dest: 'amd/build',   
                    ext: '.min.js'       
                }]
            }
        },
        watch: {
            scripts: {
                files: ['amd/src/*.js'],
                tasks: ['uglify:amd'],
                options: {
                    spawn: false
                }
            }
        }
    });

    // Load necessary tasks
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('build', ['uglify:amd']);
    grunt.registerTask('dev', ['watch']);
};
