var gulp = require('gulp');
var connect = require('gulp-connect-php');
var browserSync = require('browser-sync');
var csslint = require('gulp-csslint');


gulp.task('default', function() {
    connect.server({}, function (){
        browserSync.init({
            proxy:  '127.0.0.1:8000',
            ws: true,
            notify: true,
        });
    });

    gulp.watch([
        './**/*.php',
        './**/**/*.php',
        './local/templates/**/**/**/**/**/**/*.php',
        './local/templates/**/**/**/**/**/**/*.css',
        './local/templates/**/**/**/**/**/**/*.js',
    ]).on('change', function (file) {
        const gulpStylelint = require('gulp-stylelint');
        gulp.src(file.path)
        .pipe(gulpStylelint({
          reporters: [
            {formatter: 'string', console: true}
          ],
          failAfterError: false
        }));
        browserSync.reload();
    });
    // gulp.watch([]).on('change', function () {
    //     browserSync.reload();
    // });
});
