.PHONY: test

install-composer:
	curl -s https://getcomposer.org/installer | php

install-dev-deps:
	php composer.phar install --dev

update-dev-deps:
	php composer.phar update --dev

install-production-deps:
	php composer.phar install

update-production-deps:
	php composer.phar update

test:
	./vendor/bin/phpunit --stderr --configuration=test/phpunit.xml --exclude-group Benchmark,Database

test-all:
	./vendor/bin/phpunit --stderr --configuration=test/phpunit.xml

test-reader:
	./vendor/bin/phpunit --stderr --configuration=test/phpunit.xml --group Reader

test-writer:
	./vendor/bin/phpunit --stderr --configuration=test/phpunit.xml --group Writer

benchmark:
	./vendor/bin/phpunit --stderr --configuration=test/phpunit.xml --group Benchmark

lint:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test

ctags:
	ctags --languages=PHP --exclude=vendor --exclude=.git --exclude=composer.phar -R -f .tags

clean:
	rm -rf coverage-report-html
