Readme-Tester
=============

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/readme-tester.svg?style=flat-square)](https://packagist.org/packages/hanneskod/readme-tester)
[![Build Status](https://img.shields.io/travis/hanneskod/readme-tester/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/readme-tester)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/readme-tester.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/readme-tester)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/readme-tester.svg?style=flat-square)](https://gemnasium.com/hanneskod/readme-tester)

Validate code examples in readme files

Why?
----
No more erroneous examples in `README.md`, let phpunit tell you when your examples
are out of date!

Installation
------------
```shell
composer require --dev hanneskod/readme-tester
```

Usage
-----
<!-- @expectOutput output -->
<!-- @ignore -->
```php
echo "foobar";
```
<!-- @expectOutput output -->
<!-- @ignore -->
```php
echo "foobar";
```

### Phpunit integration

Subclass `ReadmeTestCase` to add example validation to your phpunit test suite.

<!-- @ignore -->
```php
class ReadmeTest extends \hanneskod\readmetester\ReadmeTestCase
{
    public function testReadmeExamples()
    {
        $this->assertReadme('README.md');
    }
}
```

### Using the command line tool

```shell
vendor/bin/readme-tester test README.md
```

Credits
-------
Readme-Tester is covered under the [WTFPL](http://www.wtfpl.net/)

@author Hannes Forsgård (hannes.forsgard@fripost.org)
