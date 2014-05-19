.PHONY: all test coverage

test:
	phpunit --configuration=test/phpunit.xml

clean:
	rm -r coverage-report-html
