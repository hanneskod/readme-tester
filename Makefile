COMPOSER_CMD=composer
PHIVE_CMD=phive

PHPSPEC_CMD=tools/phpspec
PHPUNIT_CMD=tools/phpunit
BEHAT_CMD=tools/behat
README_TESTER_CMD=bin/readme-tester
PHPSTAN_CMD=tools/phpstan
PHPCS_CMD=tools/phpcs
BOX_CMD=tools/box
PHAR_COMPOSER_CMD=tools/phar-composer
PHPEG_CMD=tools/phpeg

.DEFAULT_GOAL=all

TARGET=readme-tester.phar

PARSER_ROOT=src/Markdown/Parser
PARSER=$(PARSER_ROOT).php

.PHONY: all
all: test analyze build

.PHONY: clean
clean:
	rm -f composer.lock
	rm -f $(PARSER)
	rm -rf vendor
	rm -rf tools

.PHONY: build
build: $(TARGET)

$(TARGET): vendor/installed $(PARSER) $(BOX_CMD)
	$(BOX_CMD) compile

$(PARSER): $(PARSER_ROOT).peg $(PHPEG_CMD)
	$(PHPEG_CMD) generate $<

.PHONY: test
test: phpspec phpunit behat docs

.PHONY: phpspec
phpspec: vendor/installed $(PARSER) $(PHPSPEC_CMD)
	$(PHPSPEC_CMD) run

.PHONY: phpunit
phpunit: vendor/installed $(PARSER) $(PHPUNIT_CMD)
	$(PHPUNIT_CMD)

.PHONY: behat
behat: vendor/installed $(PARSER) $(BEHAT_CMD)
	$(BEHAT_CMD) --stop-on-failure

.PHONY: docs
docs: vendor/installed $(PARSER) $(README_TESTER_CMD)
	$(README_TESTER_CMD)

.PHONY: analyze
analyze: phpstan phpcs

.PHONY: phpstan
phpstan: vendor/installed $(PHPSTAN_CMD)
	$(PHPSTAN_CMD) analyze -c phpstan.neon -l 5 src

.PHONY: phpcs
phpcs: $(PHPCS_CMD)
	$(PHPCS_CMD) src --standard=PSR2 --ignore=$(PARSER),src/Parser/Parser.php
	#$(PHPCS_CMD) spec --standard=spec/ruleset.xml

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

$(PHPSPEC_CMD):
	$(PHIVE_CMD) install phpspec/phpspec:6 --force-accept-unsigned

$(PHPUNIT_CMD):
	$(PHIVE_CMD) install phpunit:8 --trust-gpg-keys 4AA394086372C20A

$(BEHAT_CMD):
	$(PHIVE_CMD) install behat/behat:3 --force-accept-unsigned

$(PHPSTAN_CMD):
	$(PHIVE_CMD) install phpstan --force-accept-unsigned

$(PHPCS_CMD):
	$(PHIVE_CMD) install phpcs:^3.5.5 --force-accept-unsigned

$(BOX_CMD):
	$(PHIVE_CMD) install humbug/box --force-accept-unsigned

$(PHAR_COMPOSER_CMD):
	$(PHIVE_CMD) install clue/phar-composer:1 --force-accept-unsigned

$(PHPEG_CMD): $(PHAR_COMPOSER_CMD)
	$(PHAR_COMPOSER_CMD) build https://github.com/scato/phpeg
	mv phpeg.phar $@
