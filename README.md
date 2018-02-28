Readme-Tester
=============

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/readme-tester.svg?style=flat-square)](https://packagist.org/packages/hanneskod/readme-tester)
[![Build Status](https://img.shields.io/travis/hanneskod/readme-tester/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/readme-tester)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/readme-tester.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/readme-tester)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/readme-tester.svg?style=flat-square)](https://gemnasium.com/hanneskod/readme-tester)

Validate PHP code examples in markdown files.

Why?
----
Did you update your library, but forgot to update code examples in README? Are
your users complaining on syntax errors in your examples? Do you find it too
cumbersome to manually test all examples? Then readme-tester is for you!

Readme-tester lets you automate the process of validating PHP code examples in
markdown files. You can use the command line tool, or integrate with your
phpunit test suite and never have to worry about failing examples again.

Table of contents
-----------------
  * [Installation](#installation)
  * [Writing examples](#writing-examples)
    * [Annotations](#annotations)
    * [Naming examples](#naming-examples)
    * [Ignoring examples](#ignoring-examples)
    * [Expectations](#expectations)
    * [Linking examples together](#linking-examples-together)
    * [Hidden examples](#hidden-examples)
    * [Creating a default example context](#creating-a-default-example-context)
  * [The command line tool](#the-command-line-tool)
  * [PHPUnit integration](#phpunit-integration)

Installation
------------
Install using composer

```shell
composer require --dev hanneskod/readme-tester:^1.0@beta
```

> NOTE! Readme-tester works just as good as a development dependency of your
> project as installed *globally*.

Writing examples
----------------
When readme-tester validates a markdown file all php colorized code blocks are
executed. In markdown this means using a fenced block with the `php` language
identifier.

    ```php
    // This code is validated
    ```

### Annotations

To specify how examples should be tested readme-tester uses annotations hidden
inside HTML comments. In this way testing related instructions are hidden when
rendered on github or similar.

A block of annotations can look like this

```
<!-- @example "an example" -->
<!-- @expectOutput /foobar/ -->
```

Or like this

```
<!--
    @example "an example"
    @expectOutput /foobar/
-->
```

Readme-tester will only recongnize annotations directly before the code block
example, meaning that there must be no content between the annotations and the
code.

#### Annotation arguments

Annotation tags are prefixed with `@` and are followed by a list of arguments
separated by spaces. If an argument includes spaces it can be enclosed in
double (`"`) or single quotes (`'`).

### Naming examples

Examples may be named using the `@example` annotation. Naming is optional but
gives better error reporting and simplifies referencing.

### Ignoring examples

Examples may be ignored using the `@ignore` annotation. Ignored examples are
not validated in any way.

<!-- @ignore -->
```php
// Example is preceded by <!-- @ignore -->
// This code is skipped, the syntax error is ignored.
echo foobar";
```

### Expectations

Add assertions to code blocks using one of the expectation annotations.
Multiple expectations can be specified for an example.

#### Expecting output

Assert the output of an example using a regular expression.

<!-- @expectOutput "/regular expression/" -->
```php
// Example is preceded by <!-- @expectOutput "/regular expression/" -->
echo "This output is matched using a regular expression";
```

If the annotation argument of `@expectOutput` is not a valid regular expression
it will be transformed into one, `abc` is transformed into `/^abc$/`.

<!-- @expectOutput abc -->
```php
// Example is preceded by <!-- @expectOutput abc -->
echo "abc";
```

### Linking examples together

An example may include a previous example using the `@include` annotation. This
will copy the code of the includeed example into the current and wrapp it in
output buffering so that output may be asserted in each of the examples.

<!--
    @example parent
    @expectOutput A
-->
```php
/*
Example is preceded by
<!--
    @example parent
    @expectOutput A
-->
*/
$data = ['parent' => 'A', 'child' => 'B'];
echo $data['parent'];
```

Now we can include the named example `parent`.

<!--
    @example child
    @include parent
    @expectOutput B
-->
```php
/*
Example is preceded by
<!--
    @example child
    @include parent
    @expectOutput B
-->
*/
echo $data['child'];
```

### Hidden examples

Sometimes you may need to set up an environment to create a context for your
examples to run in. This can be done using hidden examples. Hidden examples are
defined inside a html comment. Consider the following example:


    <!--
    @example my-hidden-example

    ```php
    // Som setup...
    $var = 'foobar';
    ```
    -->

<!--
@example my-hidden-example

```php
// Som setup...
$var = 'foobar';
```
-->

<!--
    @include my-hidden-example
    @expectOutput "foobar"
-->
```php
/*
Example is preceded by
<!--
    @include my-hidden-example
    @expectOutput "foobar"
-->
*/
echo $var;
```

### Creating a default example context

If you want every example in a readme to include a base context you can use
the `exampleContext` annotation as in the following example.

<!-- @example context -->
<!-- @exampleContext -->
```php
/*
Example is preceded by
<!-- @exampleContext -->
*/
$context = 'setup...';
```

<!-- @expectOutput /setup/ -->
```php
/*
Example is preceded by
<!-- @expectOutput /setup/ -->
*/
echo $context;
```

The command line tool
---------------------
Using the command line tool is as simple as

```shell
vendor/bin/readme-tester test README.md
```

For more detailed information use

```shell
vendor/bin/readme-tester help test
```

PHPUnit integration
-------------------
If you are using PHPUnit >= 6 you may subclass `ReadmeTestCase` and use
`assertReadme()` to test readme snippets through phpunit.

<!-- @ignore -->
```php
class ReadmeTest extends \hanneskod\readmetester\PHPUnit\ReadmeTestCase
{
    public function testReadmeIntegrationTests()
    {
        $this->assertReadme('README.md');
    }
}
```

### Integrating with global installations

If readme-tester is expected to be installed *globally* we dont't want phpunit
to break when readme-tester is not present. Use the `AssertReadme` class instead
of subclassing `ReadmeTestCase`.

<!-- @ignore -->
```php
class GlobalReadmeIntegration extends \PHPUnit\Framework\TestCase
{
    public function testReadmeIntegrationTests()
    {
        if (!class_exists('hanneskod\readmetester\PHPUnit\AssertReadme')) {
            $this->markTestSkipped('Readme-tester is not available.');
        }

        (new \hanneskod\readmetester\PHPUnit\AssertReadme($this))->assertReadme('README.md');
    }
}
```
