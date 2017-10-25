var gulp = require('gulp'),
connect = require('gulp-connect-php'),
browserSync = require('browser-sync');

gulp.task('default', function() {
    connect.server({}, function (){
        browserSync.init({
            proxy:  '127.0.0.1:8000',
            ws: true,
            notify: true,
        });
    });

    gulp.watch('./**/**/**/*.php').on('change', function () {
        browserSync.reload();
    });
    gulp.watch(['./**/*.css', './**/*.js']).on('change', function () {
        browserSync.reload();
    });
});
