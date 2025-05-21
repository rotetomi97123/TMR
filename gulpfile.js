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
    src: "scss/**/*.scss",
    dest: "css",
  },
  html: {
    src: "*.html",
  },
};

// Compile SCSS
function compileScss() {
  return gulp
    .src(paths.scss.src)
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(autoprefixer())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.scss.dest))
    .pipe(bs.stream()); // Inject changes without full reload
}

// Live Server
function serve() {
  bs.init({
    server: {
      baseDir: "./", // Serve from root
    },
    notify: false,
  });

  gulp.watch(paths.scss.src, compileScss);
  gulp.watch(paths.html.src).on("change", bs.reload);
}

// Export tasks
export const build = compileScss;
export const watch = serve;
export default gulp.series(build, serve);
