.PHONY: test test-all clean phpcs

test:
	phpunit --stderr --configuration=test/phpunit.xml --exclude-group Benchmark,Client

test-all:
	phpunit --stderr --configuration=test/phpunit.xml

test-reader:
	phpunit --stderr --configuration=test/phpunit.xml --group Reader

clean:
	rm -rf coverage-report-html

phpcs:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test
