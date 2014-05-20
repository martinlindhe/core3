# Linter: php -l

                        # time on macbook air
  make lint             # 6.3s
  make -j 4 lint        # 3.1s
  make -j 8 lint        # 3.1s



# Linter: phpmd, "PHP Mess Detector"

http://phpmd.org/

Is configured in composer.json

STATUS: has troubles detecting static method usage (false positives) 



# Linter: phpcs

http://pear.php.net/package/PHP_CodeSniffer/

Is configured in composer.json (1.5.3)

  git clone https://github.com/squizlabs/PHP_CodeSniffer.git

STATUS: 2.0 alpha TODO not available as composer install?



# Linter: PHPLint

http://www.icosaedro.it/phplint/download.html
http://www.icosaedro.it/phplint/phplint-2.0_20140331.tar.gz

STATUS: ???
