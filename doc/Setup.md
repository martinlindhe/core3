# Requirements

PHP 5.3.7 is minimum requirement, due to password_compat requirements




# Install 1: Dependencies for development

In order to simplify setup, requirement must be installed using composer

In the document root, install composer in your project:

  make install-composer

Next, let composer install project depencencies + required dev tools (phpunit, hp_codesniffer):

  make install-dev-deps



# Install 1: Dependencies for production

  make install-composer && make install-production-deps



# Install 2: Upgrade dependencies

After changes to composer.json, depenencies need to be updated:

  make update-production-deps



# Install 2: Link to core3

Then add a symlink to core3 in the project root directory:

  ln -s /path/to/core3 /path/to/core3_app1/core3

(Or check out the repository to core3)






# PHP version matrix (May 2014)

OSX 10.9 (Mavericks):         PHP 5.4.24 (cli) (built: Jan 19 2014 21:32:15)

Debian sid (unstable):        php5 5.5.12+dfsg-2
Debian wheezy (stable):       php5 5.4.4-14+deb7u9
Debian squeeze (oldstable):   php5 5.3.3-7+squeeze19
Debian lenny (old):           php5 5.2.6.dfsg.1-1+lenny13

Ubuntu 14.04 LTS (trusty):    php5 5.5.9+dfsg-1ubuntu4
Ubuntu 12.04 LTS (precise):   php5 5.3.10-1ubuntu3.11
Ubuntu 10.04 LTS (lucid):     php5 5.3.2-1ubuntu4.24





## PDO sqlite driver

### OSX

pdo_sqlite is available out of the box

### Debian

  sudo apt-get install php5-sqlite




# Apache setup


XXX




# Sendmail setup

Uses the system sendmail mail transfer agent


