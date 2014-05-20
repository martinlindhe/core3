.PHONY: test clean lint

test:
	phpunit --stderr --configuration=test/phpunit.xml --exclude-group Benchmark,Client

test-all:
	phpunit --stderr --configuration=test/phpunit.xml

clean:
	rm -rf coverage-report-html

phpcs:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test
