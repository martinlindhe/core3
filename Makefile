.PHONY: all test coverage

test:
	phpunit --stderr --configuration=test/phpunit.xml

clean:
	rm -r coverage-report-html
