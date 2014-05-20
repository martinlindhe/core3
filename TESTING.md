
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




# Run tests

In root directory

  make test

This will also generate code coverage in coverage-report-html/
