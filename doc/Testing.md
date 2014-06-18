
# XDebug

Install from git:

  git clone https://github.com/derickr/xdebug.git
  cd xdebug
  phpize
  ./configure --enable-xdebug

  make

  sudo cp -r modules/  /usr/local/xdebug


To activate, add the following to php.ini:

  [Xdebug]
  zend_extension=/usr/local/xdebug/xdebug.so





# PHPUnit

Install on OSX and Debian:

  curl -O https://phar.phpunit.de/phpunit.phar
  chmod +x phpunit.phar
  sudo mv phpunit.phar /usr/local/bin/phpunit



# Karma

TODO use to unit test js code

Requires npm:

  sudo port install npm   # from macports


Install Karma:
  npm install karma --save-dev

Install plugins that your project needs:
  npm install karma-jasmine karma-chrome-launcher grunt-karma karma-ng-scenario --save-dev

Install karma-cli and protractor globally:
  sudo npm install karma-cli protractor -g



# UglifyJS

Install globally:

  sudo npm install uglify-js -g




# Run tests

In root directory

  make test

This will also generate code coverage in coverage-report-html/
