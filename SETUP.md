# Requirements

PHP 5.3.7 is minimum requirement, due to password_compat requirements



# Install requirements using composer

In the document root, install composer in your project:

  curl -s https://getcomposer.org/installer | php

Let composer install project depencencies:

  php composer.phar install --dev

After changes to composer.json, update depenencies:

  php composer.phar update --dev


TODO drop lib/tcpdf when bugs are resolved, 2014-05-20


# PHP version matrix, 2014

OSX 10.9 (Mavericks):         PHP 5.4.24 (cli) (built: Jan 19 2014 21:32:15)

Debian sid (unstable):        php5 5.5.12+dfsg-2
Debian wheezy (stable):       php5 5.4.4-14+deb7u9
Debian squeeze (oldstable):   php5 5.3.3-7+squeeze19
Debian lenny (old):           php5 5.2.6.dfsg.1-1+lenny13

Ubuntu 14.04 LTS (trusty):    php5 5.5.9+dfsg-1ubuntu4
Ubuntu 12.04 LTS (precise):   php5 5.3.10-1ubuntu3.11
Ubuntu 10.04 LTS (lucid):     php5 5.3.2-1ubuntu4.24




## PEAR + PECL

  curl -O https://pear.php.net/go-pear.phar
  sudo php go-pear.phar


type 1, enter /usr/local/pear

type 4, enter /usr/local/bin

  * source: http://jason.pureconcepts.net/2012/10/install-pear-pecl-mac-os-x/






## php5-sqlite

### OSX

pdo_sqlite is available out of the box

### Debian

  sudo apt-get install php5-sqlite





## Password hashing with bcrypt

  php 5.5, or password_compat

  password_compat is shipped in lib/password_compat

TODO make sure native password_hash() is used on php 5.5 (debian sid)





## PDF support

tcpdf 6.0.078 (released 2014-05-12) is shipped in lib/tcpdf
Licence: GPL
Source: http://sourceforge.net/projects/tcpdf/files/

RATIONALE FOR TCPDF: tcpdf supports HTML to PDF, which is required; haru does not

OPEN PATCH: https://sourceforge.net/p/tcpdf/patches/70/
	TODO when patch is accepted, drop my lib/tcpdf and use composer to fetch tcpdf instead

