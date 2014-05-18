.PHONY: all test coverage

test:
	phpunit --configuration=test/phpunit.xml

coverage:
	phpunit --coverage-html coverage-report-html --configuration test/phpunit.xml

clean:
	rm -r coverage-report-html
