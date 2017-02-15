#!/usr/bin/env sh
set -e
vendor/bin/phpunit
vendor/bin/behat --stop-on-failure
