.PHONY: test

setup: install-composer install-deps

install-deps:
	composer install

update-deps:
	composer update

test:
	./vendor/bin/phpunit --exclude-group Database,Mailer

test-hhvm:
	hhvm /usr/local/bin/phpunit --exclude-group Database,Mailer,HhvmIncompatible

test-all:
	./vendor/bin/phpunit

lint:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test view

lint-md:
	./vendor/bin/phpmd class text cleancode

lint-json:
	./vendor/bin/jsonlint composer.json

ctags:
	ctags --languages=PHP --exclude=vendor --exclude=.git --exclude=composer.phar -R -f .tags

clean:
	rm -rf coverage-report-html
