.PHONY: test

install-composer:
	curl -s https://getcomposer.org/installer | php

install-deps:
update-deps:
	php composer.phar update --dev

update-prod-deps:
update-production-deps:
	php composer.phar update

test:
	./vendor/bin/phpunit --exclude-group Benchmark,Database

test-all:
	./vendor/bin/phpunit

benchmark:
	./vendor/bin/phpunit --group Benchmark

lint:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test view

ctags:
	ctags --languages=PHP --exclude=vendor --exclude=.git --exclude=composer.phar -R -f .tags

clean:
	rm -rf coverage-report-html
