const gulp = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
var reload = browserSync.reload;

gulp.task('sass', function() {
    return gulp.src("scss/styles.scss")
        .pipe(sass())
        .pipe(gulp.dest("../css"))
        .pipe(browserSync.stream());
});

gulp.task('watch', gulp.series('sass', function() {

    browserSync.init({
        // server: "./app/"
        proxy: "http://localhost:8888/oop_site"
    });

    gulp.watch("scss/*.scss", gulp.series('sass'), browserSync.reload);
    gulp.watch("../**/*.php").on('change', browserSync.reload);
    // gulp.watch("./*.php", ['php']); 
}));

gulp.task('default', gulp.series('watch'));