.PHONY: test

test:
	phpunit --stderr --configuration=test/phpunit.xml --exclude-group Benchmark,Client

test-all:
	phpunit --stderr --configuration=test/phpunit.xml

test-reader:
	phpunit --stderr --configuration=test/phpunit.xml --group Reader

benchmark:
	phpunit --stderr --configuration=test/phpunit.xml --group Benchmark

clean:
	rm -rf coverage-report-html

lint:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test

install-dev-deps:
	php composer.phar install --dev

update-dev-deps:
	php composer.phar update --dev

install-production-deps:
	php composer.phar install

update-production-deps:
	php composer.phar update
