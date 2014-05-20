# Linter: php -l

                        # time on macbook air
  make lint             # 6.3s
  make -j 4 lint        # 3.1s
  make -j 8 lint        # 3.1s



# Linter: phpmd

http://phpmd.org/download/index.html

REQUIRE: "ant" on cli;   macports:  $ sudo port install apache-ant

  git clone git://github.com/phpmd/phpmd.git

STATUS: ???



# Linter: phpcs

http://pear.php.net/package/PHP_CodeSniffer/

  git clone https://github.com/squizlabs/PHP_CodeSniffer.git

STATUS: ???



# Linter: PHPLint

http://www.icosaedro.it/phplint/download.html
http://www.icosaedro.it/phplint/phplint-2.0_20140331.tar.gz

STATUS: ???
