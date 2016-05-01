Readme-Tester
=============

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/readme-tester.svg?style=flat-square)](https://packagist.org/packages/hanneskod/readme-tester)
[![Build Status](https://img.shields.io/travis/hanneskod/readme-tester/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/readme-tester)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/readme-tester.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/readme-tester)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/readme-tester.svg?style=flat-square)](https://gemnasium.com/hanneskod/readme-tester)

Validate code examples in readme files.

Why?
----
Did you update your library, but forgot to update code examples in README? Are
your users complaining on syntax errors in your examples? Do you find it too cumbersome
to manually test all examples? Then readme-tester is for you!

Readme-tester lets you automate the process of validating code examples in readme
files. Integrate with your phpunit test suite and you will never have to worry about
failing examples again.

Installation
------------
```shell
composer require --dev hanneskod/readme-tester:dev-master
```

Usage
-----
When readme-testar validates a readme file all php colorized code blocks are executed.
In markdown this means using a fenced block with the `php` language identifier. View
the raw contents of [this file](/README.md) for an example.

```php
// This code is validated
```

### Ignoring examples

To ignore an example when testing annotate it with an `@ignore` tag inside an html
comment just before the code block.

<!-- @ignore -->
```php
// This code is skipped, the syntax error is ignored.
echo foobar";
```

### Adding expectations

Add assertions to code blocks using one of the expectation annotations. Multiple
expectations can be specified for each example.

<!-- @expectOutput /regular expression/ -->
```php
// Example is preceded by <!-- @expectOutput /regular expression/ -->
echo "This output is matched using a regular expression";
```

<!-- @expectException Exception -->
```php
// Example is preceded by <!-- @expectException Exception -->
throw new Exception();
```

<!-- @expectReturnType integer -->
```php
// Example is preceded by <!-- @expectReturnType integer -->
// Type descriptor used by gettype() or a class name can be used
return 1;
```

<!-- @expectReturn /foo/ -->
```php
// Example is preceded by <!-- @expectReturn /foo/ -->
return 'foo';
```

<!-- @expectNothing -->
```php
// Example is preceded by <!-- @expectNothing -->
// nothing is expected here..
```

PHPUnit integration
-------------------
Subclass `ReadmeTestCase` and use `assertReadme()` to run readme snippets
through phpunit. To add a different testsuite for readme testing remove the
`Test` suffix from the class name and define a testsuite in `phpunit.xml`.
A standard setup may look like the following:

```php
class ReadmeIntegration extends \hanneskod\readmetester\PHPUnit\ReadmeTestCase
{
    public function testReadmeIntegrationTests()
    {
        $this->assertReadme('README.md');
    }
}
```

```xml
<phpunit bootstrap="./vendor/autoload.php">
    <testsuites>
        <testsuite name="default">
            <directory>./tests</directory>
        </testsuite>
        <testsuite name="readme">
            <file>./tests/ReadmeIntegration.php</file>
        </testsuite>
    </testsuites>
    <filter>
        <whitelist>
            <directory suffix=".php">./src</directory>
        </whitelist>
    </filter>
</phpunit>
```

Using the command line tool
---------------------------
```shell
vendor/bin/readme-tester test README.md
```

Supported formats
-----------------
Currently only markdown is supported. Open an issue or submit a pull request to
add your format of choice. See the [markdown](/src/Format/Markdown.php) implementation
to get started.

Credits
-------
Readme-Tester is covered under the [WTFPL](http://www.wtfpl.net/)

@author Hannes Forsgård (hannes.forsgard@fripost.org)
