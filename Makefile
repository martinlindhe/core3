test:
#	phpunit --report-useless-tests --disallow-test-output --colors --bootstrap tests/bootstrap.php tests/
	phpunit --colors --bootstrap tests/bootstrap.php tests/

coverage:
	phpunit --colors --bootstrap tests/bootstrap.php --coverage-html coverage-report-html tests/
