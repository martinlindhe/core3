php_files := $(shell find . -name \*.php)

.PHONY: test clean lint ${php_files}

test:
	phpunit --stderr --configuration=test/phpunit.xml --exclude-group Benchmark,Client

test-all:
	phpunit --stderr --configuration=test/phpunit.xml

clean:
	rm -rf coverage-report-html
	rm -f phpmd-report.html

${php_files}:
	@php -l $@

lint: ${php_files}
	@echo Lint finished

phpmd-html:
	./vendor/bin/phpmd class html cleancode > phpmd-report.html

phpmd-text:
	./vendor/bin/phpmd class text cleancode

phpcs:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class
