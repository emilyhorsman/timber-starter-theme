'use strict';

var path         = require('path');
var gulp         = require('gulp');
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

var paths = {
  src:  { },
  dist: { }
};
paths.src.sass  = path.join('.', 'sass');
paths.dist.sass = path.join('.', 'css');

gulp.task('sass', function() {
  return gulp.src(path.join(paths.src.sass, '**/*.scss'))
    .pipe(sass({
      includePaths: './bower_components'
    }))
    .pipe(autoprefixer({
      // Autoprefixer settings from:
      // https://github.com/twbs/bootstrap/blob/v4.0.0-alpha/Gruntfile.js#L229
      browsers: [
        'Android 2.3',
        'Android >= 4',
        'Chrome >= 35',
        'Firefox >= 31',
        'Explorer >= 9',
        'iOS >= 7',
        'Opera >= 12',
        'Safari >= 7.1'
      ]
    }))
    .pipe(gulp.dest(paths.dist.sass));
});

gulp.task('watch', function() {
  return gulp.watch(path.join(paths.src.sass, '**/*.scss'), ['sass']);
});

gulp.task('build', ['sass']);
gulp.task('default', ['watch']);
