php_files := $(shell find . -name \*.php)

.PHONY: test clean lint ${php_files}

test:
	phpunit --stderr --configuration=test/phpunit.xml --exclude-group Client

clean:
	rm -rf coverage-report-html

${php_files}:
	@php -l $@

lint: ${php_files}
	@echo Lint finished
