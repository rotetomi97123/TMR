import gulp from "gulp";
import dartSass from "sass";
import gulpSass from "gulp-sass";
import autoprefixer from "gulp-autoprefixer";
import cleanCSS from "gulp-clean-css";
import sourcemaps from "gulp-sourcemaps";
import browserSync from "browser-sync";

const sass = gulpSass(dartSass);
const bs = browserSync.create();

// File paths
const paths = {
  scss: {
    entry: "scss/styles.scss",
    dest: "css",
    watch: "scss/**/*.scss",
  },
  php: {
    src: "**/*.php", // Watch all PHP files, including index.php and includes
  },
};

// Compile SCSS
function compileScss() {
  return gulp
    .src(paths.scss.entry)
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(autoprefixer())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.scss.dest))
    .pipe(bs.stream()); // Inject changes without full reload
}

// Live Server with PHP support
function serve() {
  bs.init({
    proxy: "localhost", // assumes you're running PHP via something like XAMPP, WAMP, MAMP, or `php -S`
    notify: false,
    open: true,
    port: 3000,
  });

  gulp.watch(paths.scss.watch, compileScss);
  gulp.watch(paths.php.src).on("change", bs.reload);
}

// Export tasks
export const build = compileScss;
export const watch = serve;
export default gulp.series(build, serve);
