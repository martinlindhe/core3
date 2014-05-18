# Requirements

PHP 5.3.7 is minimum requirement, due to password_compat requirements

# PHP version matrix, 2014

OSX Mavericks shipped: PHP 5.4.24 (cli) (built: Jan 19 2014 21:32:15)

Ubuntu 14.04 LTS (trusty):    php5 5.5.9+dfsg-1ubuntu4
Ubuntu 12.04 LTS (precise):   php5 5.3.10-1ubuntu3.11
Ubuntu 10.04 LTS (lucid):     php5 5.3.2-1ubuntu4.24
Debian sid (unstable):        php5 5.5.12+dfsg-2
Debian wheezy (stable):       php5 5.4.4-14+deb7u9
Debian squeeze (oldstable):   php5 5.3.3-7+squeeze19





## PEAR + PECL

  curl -O https://pear.php.net/go-pear.phar
  sudo php go-pear.phar

type 1, enter /usr/local/pear

type 4, enter /usr/local/bin

  * source: http://jason.pureconcepts.net/2012/10/install-pear-pecl-mac-os-x/






## php5-sqlite

  TODO osx?





## Password hashing with bcrypt

  php 5.5, or password_compat

  password_compat is shipped in lib/password_compat

TODO make sure native password_hash() is used on php 5.5 (debian sid)






## Testing: XDebug

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





## Testing: PHPUnit

Install on OSX and Debian:

  curl -O https://phar.phpunit.de/phpunit.phar
  chmod +x phpunit.phar
  sudo mv phpunit.phar /usr/local/bin/phpunit





## Run tests

  make test

This will also generate code coverage in coverage-report-html/





## PDF support

tcpdf 6.0.078 is shipped in lib/tcpdf
Licence: GPL

TODO USE A GIT SNAPSHOT INSTEAD:   git clone http://git.code.sf.net/p/tcpdf/code tcpdf-code


