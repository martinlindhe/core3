# The Gulp task runner

TODO maybe use LiveReload plugin: https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei?hl=en

    TODO replace with a package.json

Install globally:

  sudo npm install gulp -g

From project root, install locally:

  npm install gulp --save-dev

Install gulp plugins, TODO make use of these!

  npm install gulp-sass gulp-minify-css \
      gulp-htmlhint \
      gulp-autoprefixer \
      gulp-jshint gulp-concat gulp-uglify gulp-clean gulp-notify gulp-rename gulp-livereload gulp-cache \
      --save-dev

XXX TODO "gulp-imagemin" failed to install, seem to hit
    https://github.com/npm/npm/issues/4014
