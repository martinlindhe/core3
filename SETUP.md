# Requirements

## PEAR + PECL

  curl -O http://pear.php.net/go-pear.phar
  sudo php go-pear.phar

  type 1, enter /usr/local/pear
  type 4, enter /usr/local/bin

XXX add pear include path to php.ini

  * source: http://jason.pureconcepts.net/2012/10/install-pear-pecl-mac-os-x/


## php5-sqlite

  xxx



## Password

  php 5.5, or



## Testing

PHPUnit 4.1




## PDF support

first install libharu

osx, tried & failed using the "libharu" pkg from macports:

  sudo port install libharu


debian:
  git clone https://github.com/libharu/libharu.git
  ...



next, install PECL/haru

  $ sudo pecl install haru

  path for haru is /opt/local/lib   (name is libhpdf for some reason)


  * https://github.com/libharu/libharu/
  * http://pecl.php.net/package/haru
