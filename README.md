# exemplify


Generate markdown formatted documentation from phpunit test suites.

No more erroneous examples in README.md. Let phpunit tell you when your examples
are out of date, and let exemplify generate markdown when examples are fixed.

Se [EXAMPLES.md](EXAMPLES.md) for a live example.


Installation using [composer](http://getcomposer.org/)
------------------------------------------------------
    "require-dev": {
        "hanneskod/exemplify": "dev-master@dev",
    }


Run tests using [phpunit](http://phpunit.de/)
---------------------------------------------
To run the tests you must first install dependencies using composer.

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ phpunit
