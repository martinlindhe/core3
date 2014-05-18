# Requirements

PHP 5.3.7 is minimum requirement, due to password_compat requirement

# PHP version matrix, 2014

OSX Mavericks shipped: PHP 5.4.24 (cli) (built: Jan 19 2014 21:32:15)

Ubuntu 14.04 LTS:          xxx
Ubuntu 12.04 LTS:          xxxx
Debian sid (unstable):        php5 5.5.12+dfsg-2
Debian wheezy (stable):       php5 5.4.4-14+deb7u9
Debian squeeze (oldstable):   php5 5.3.3-7+squeeze19

## PEAR + PECL

  curl -O https://pear.php.net/go-pear.phar
  sudo php go-pear.phar

  type 1, enter /usr/local/pear
  type 4, enter /usr/local/bin

XXX add pear include path to php.ini

  * source: http://jason.pureconcepts.net/2012/10/install-pear-pecl-mac-os-x/




## php5-sqlite

  xxx




## Password hashing with bcrypt

  php 5.5, or password_compat

  TODO use password_compat







## Testing: XDebug

Install from git:

  git clone https://github.com/derickr/xdebug.git
  cd xdebug
  phpize
  ./configure --enable-xdebug

  make

it will compile and create module directory inside current location
Copy Modules Directory to php extensions directory

  sudo cp -r modules/  /usr/local/xdebug

To activate, add the following in php.ini:


  [Xdebug]
  zend_extension=/usr/local/xdebug/xdebug.so


## Testing: PHPUnit

Install on OSX and Debian:

  curl -O https://phar.phpunit.de/phpunit.phar
  chmod +x phpunit.phar
  sudo mv phpunit.phar /usr/local/bin/phpunit


run tests:

  make test





## PDF support

TODO install tcpdf using pear & current code, instead of debian packaged one


STABLE FROM http://sourceforge.net/projects/tcpdf/files/tcpdf_6_0_078.zip/download

or git:

 TODO INSTALL FROM GIT:   git clone http://git.code.sf.net/p/tcpdf/code tcpdf-code

### debian

  sudo apt-get install php-tcpdf


### OSX

  TODO!
