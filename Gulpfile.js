var gulp        = require('gulp');
var compass     = require('gulp-compass');

// Compile SASS & auto-inject into browsers for development
gulp.task('compass', function () {
    return gulp.src('sass/*.sass')
        .pipe(compass({
	      config_file: './config.rb',
	      css: 'assets/css/dev',
	      sass: 'assets/sass'
	    }))
});

// Compile SASS & auto-inject into browsers for production
gulp.task('dist', function () {
    return gulp.src('sass/*.sass')
        .pipe(compass({
          config_file: './config-dist.rb',
          css: 'assets/css/dist',
          sass: 'assets/sass'
        }))
});

// Watch sass AND html files, doing different things with each.
gulp.task('default', ['compass'], function () {
    gulp.watch("sass/*.sass", ['compass']);
});