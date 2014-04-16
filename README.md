# exemplify [![Build Status](https://travis-ci.org/hanneskod/exemplify.svg)](https://travis-ci.org/hanneskod/exemplify) [![Code Coverage](https://scrutinizer-ci.com/g/hanneskod/exemplify/badges/coverage.png?s=d05285c0d262cea38f82c7ae95cd97af8687a83b)](https://scrutinizer-ci.com/g/hanneskod/exemplify/) [![Dependency Status](https://gemnasium.com/hanneskod/exemplify.svg)](https://gemnasium.com/hanneskod/exemplify)


Generate markdown formatted documentation from phpunit test suites.

No more erroneous examples in README.md. Let phpunit tell you when your examples
are out of date, and let exemplify generate markdown when examples are fixed.


Installation using [composer](http://getcomposer.org/)
------------------------------------------------------
    "require-dev": {
        "hanneskod/exemplify": "dev-master@dev",
    }


Usage
-----
Se [EXAMPLES.md](EXAMPLES.md) for a live example and usage instructions.

The examples has been generated from [BaseExamples.php](tests/BaseExamples.php)
and [ExpectationExamples.php](tests/ExpectationExamples.php) in the tests directory
using the command

    $ vendor/bin/exemplify --headline=Usage > EXAMPLES.md

Exemplify looks for a phpunit configuration file, and if found scans all test
locations for exemplify examples. If you already use a phpunit configuration file
no further configuration is neccesary. Just add exemplify examples to your regular
test directory.

For more information on how to use the console application

    $ vendor/bin/exemplify --help


Phpunit and the use of suffixes
-------------------------------
Phpunit requires test files to bee suffixed with `Test.php`. If you want to name
your example files differently change the suffix option in phpunit.xml.

    <phpunit bootstrap="./vendor/autoload.php">
        <testsuites>
            <testsuite>
                <directory suffix=".php">./tests</directory>
            </testsuite>
        </testsuites>
        <filter>
            <whitelist>
                <directory suffix=".php">./src</directory>
            </whitelist>
        </filter>
    </phpunit>


Run tests using [phpunit](http://phpunit.de/)
---------------------------------------------
To run the unit tests you must first install dependencies using composer.

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ phpunit
