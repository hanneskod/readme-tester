Readme-Tester
=============

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/readme-tester.svg?style=flat-square)](https://packagist.org/packages/hanneskod/readme-tester)
[![Build Status](https://img.shields.io/travis/hanneskod/readme-tester/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/readme-tester)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/readme-tester.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/readme-tester)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/readme-tester.svg?style=flat-square)](https://gemnasium.com/hanneskod/readme-tester)

Validate code examples in readme files

Why?
----
Did you update your library, but forgot to update code examples in `README.md`? Are
your users complaining on syntax errors in your examples? Do you find it too cumbersome
to manually test all examples? Then readme-tester is for you!

Readme-tester lets you automate the process of validating code examples in readme
files. Integrate with your phpunit test suite and you will never have to worry about
failing examples again.

Installation
------------
```shell
composer require --dev hanneskod/readme-tester
```

Usage
-----
When readme-testar validates a readme file all php colorized code blocks are executed.
In markdown this means using a fenced block with the `php` language identifier: `\`\`\`php`.

```php
// This code is validated
```

To ignore an example when testing annotate it with an `@ignore` tag inside an html
comment just before the code block.

`<!-- @ignore -->`
<!-- @ignore -->
```php
// This code is skipped, the syntax error is ignored.
echo foobar";
```

Add assertions to code blocks using one of the expectation annotations. Multiple
expectations can be specified for each example.


`<!-- @expectOutput /regular expression/ -->`
<!-- @expectOutput /regular expression/ -->
```php
echo "This output is matched using a regular expression";
```

`<!-- @expectException Exception -->`
<!-- @expectException Exception -->
```php
throw new Exception();
```

`<!-- @expectReturnType integer -->`
<!-- @expectReturnType integer -->
```php
return 1;
```

`<!-- @expectReturnType integer -->`
<!-- @expectReturnType integer -->
```php
return 1;
```

`<!-- @expectReturn /foo/ -->`
<!-- @expectReturn /foo/ -->
```php
return 'foo';
```

`<!-- @expectNothing -->`
<!-- @expectNothing -->
```php
// nothing is expected here..
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

### Supported formats

Currently only markdown is supported. Open an issue or submit a pull request to
add your format of choice. See the [markdown](/src/Format/Markdown.php) implementation
to get started.

Credits
-------
Readme-Tester is covered under the [WTFPL](http://www.wtfpl.net/)

@author Hannes Forsgård (hannes.forsgard@fripost.org)
