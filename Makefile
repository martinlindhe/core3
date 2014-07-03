.PHONY: test

install-composer:
	curl -sS https://getcomposer.org/installer | php

install-deps update-deps:
	php composer.phar update --dev

update-prod-deps update-production-deps:
	php composer.phar update

test:
	./vendor/bin/phpunit --exclude-group Database,Mailer

test-all:
	./vendor/bin/phpunit

lint:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test view

lint-json:
	./vendor/bin/jsonlint composer.json

ctags:
	ctags --languages=PHP --exclude=vendor --exclude=.git --exclude=composer.phar -R -f .tags

clean:
	rm -rf coverage-report-html
