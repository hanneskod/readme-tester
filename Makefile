COMPOSER_CMD=composer
PHIVE_CMD=phive
GPG_CMD=gpg

PHPSPEC_CMD=tools/phpspec
README_TESTER_CMD=bin/readme-tester
PHPSTAN_CMD=tools/phpstan
PHPCS_CMD=tools/phpcs
BOX_CMD=tools/box
PHPEG_CMD=tools/phpeg

TARGET=readme-tester.phar
DESTDIR=/usr/local/bin
VERSION=VERSION

SIGNATURE=${TARGET}.asc
SIGNATURE_ID=hannes.forsgard@fripost.org

CONTAINER=src/ProjectServiceContainer.php

PARSER_ROOT=src/InputLanguage/Markdown/Parser
PARSER=$(PARSER_ROOT).php

ETC_FILES:=$(shell find etc/ -type f -name '*')
SRC_FILES:=$(shell find src/ -type f -name '*.php' ! -path $(CONTAINER))

.DEFAULT_GOAL=all
.PHONY: all
all: test analyze preconds build check

.PHONY: clean maintainer-clean

clean: clean_before_build
	rm -f $(TARGET)
	rm -f composer.lock
	rm -rf vendor
	rm -rf tools

maintainer-clean: clean
	@echo 'This command is intended for maintainers to use; it'
	@echo 'deletes files that may need special tools to rebuild.'
	rm -f $(CONTAINER)
	rm -f $(PARSER)

.PHONY: preconds dependency_check clean_before_build

preconds: dependency_check clean_before_build

dependency_check: vendor/installed
	$(COMPOSER_CMD) validate --strict

clean_before_build:
	rm -f $(VERSION)
	rm -f $(SIGNATURE)

.PHONY: build build_release check

build: $(TARGET)

build_release: all sign

check: $(TARGET)
	./$(TARGET) --exclude 'docs/10-extensions.md' --no-bootstrap

$(CONTAINER): vendor/installed $(ETC_FILES) $(SRC_FILES)
	bin/build_container > $@

$(PARSER): $(PARSER_ROOT).peg $(PHPEG_CMD)
	$(PHPEG_CMD) generate $<

$(TARGET): vendor/installed $(CONTAINER) $(PARSER) $(SRC_FILES) $(VERSION) $(README_TESTER_CMD) box.json composer.lock $(BOX_CMD)
	$(COMPOSER_CMD) install --prefer-dist --no-dev
	$(BOX_CMD) compile
	$(COMPOSER_CMD) install

.PHONY: build check

$(VERSION):
	git describe > $@

.PHONY: sign

sign: $(SIGNATURE)

$(SIGNATURE): $(TARGET)
	$(GPG_CMD) -u $(SIGNATURE_ID) --detach-sign --output $@ $<

.PHONY: install uninstall

install: $(TARGET)
	mkdir -p $(DESTDIR)
	cp $< $(DESTDIR)/readme-tester

uninstall:
	rm -f $(DESTDIR)/readme-tester

.PHONY: test phpspec docs

test: phpspec docs

phpspec: vendor/installed $(PARSER) $(PHPSPEC_CMD)
	$(PHPSPEC_CMD) run

docs: vendor/installed $(CONTAINER) $(PARSER) $(README_TESTER_CMD)
	$(README_TESTER_CMD)

.PHONY: continuous-integration

continuous-integration: $(PHPSPEC_CMD) $(README_TESTER_CMD)
	$(PHPSPEC_CMD) run -v
	$(README_TESTER_CMD) --output debug
	$(MAKE) phpstan

.PHONY: analyze phpstan phpcs

analyze: phpstan phpcs

phpstan: vendor/installed $(PHPSTAN_CMD)
	$(PHPSTAN_CMD) analyze -c phpstan.neon -l 8 src

phpcs: $(PHPCS_CMD)
	# TODO phpcs does not currently run with php8, skipp temporary
	# $(PHPCS_CMD) src --standard=PSR2 --ignore=$(PARSER),$(CONTAINER)
	$(PHPCS_CMD) spec --standard=spec/ruleset.xml

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

tools/installed: .phive/phars.xml
	$(PHIVE_CMD) install --force-accept-unsigned --trust-gpg-keys CF1A108D0E7AE720,31C7E470E2138192,0FD3A3029E470F86
	touch $@

$(PHPSPEC_CMD): tools/installed
$(PHPSTAN_CMD): tools/installed
$(PHPCS_CMD): tools/installed
$(BOX_CMD): tools/installed
$(PHPEG_CMD): tools/installed
