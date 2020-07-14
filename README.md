Readme-Tester
=============

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/readme-tester.svg?style=flat-square)](https://packagist.org/packages/hanneskod/readme-tester)
[![Build Status](https://img.shields.io/travis/hanneskod/readme-tester/master.svg?style=flat-square)](https://travis-ci.com/github/hanneskod/readme-tester)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/readme-tester.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/readme-tester)

Validate PHP code examples in markdown files.

Why?
----
Did you update your library, but forgot to update code examples in README? Are
your users complaining on syntax errors in your examples? Do you find it too
cumbersome to manually test all examples? Then readme-tester is for you!
Readme-tester lets you automate the process of validating PHP code examples in
markdown files.

Table of contents
-----------------
  * [Installation](#installation)
  * [Writing examples](#writing-examples)
    * [Attributes](#attributes)
    * [Naming examples](#naming-examples)
    * [Ignoring examples](#ignoring-examples)
    * [Expectations](#expectations)
    * [Linking examples together](#linking-examples-together)
    * [Hidden examples](#hidden-examples)
    * [Creating a default example context](#creating-a-default-example-context)
  * [The command line tool](#the-command-line-tool)

Installation
------------
Install using composer

```shell
composer require --dev hanneskod/readme-tester
```

Writing examples
----------------
When readme-tester validates a markdown file all php colorized code blocks are
executed. In markdown this means using a fenced block with the `php` language
identifier.

    ```php
    // This code is validated
    ```

### Attributes

To specify how examples should be tested readme-tester uses php8 attributes.
Attributes may be hidden inside HTML comments, to make sure that instructions
related to testing are not rendered on github or similar.

A set of attributes may look like this

```
<<ReadmeTester\Example('name')>>
<<ReadmeTester\ExpectOutput('/foobar/')>>
```

Or like this

```
<!--
<<ReadmeTester\Example('name')>>
<<ReadmeTester\ExpectOutput('/foobar/')>>
-->
```

### Naming examples

Examples may be named using the `Example` attribute, where naming is optional,
or by using the `Name` attribute. Naming gives better error reporting and
simplifies referencing.

### Ignoring examples

Examples may be ignored using the `Ignore` attribute. Ignored examples are
not validated in any way.

<<ReadmeTester\Ignore>>
```php
// This code is skipped, the syntax error is ignored.
echo foobar";
```

### Expectations

Add assertions to code blocks using one of the expectation attributes.
Multiple expectations can be specified for an example.

#### Expecting output

Assert the output of an example using a regular expression.

<<ReadmeTester\ExpectOutput('/regular expression/')>>
```php
echo "This output is matched using a regular expression";
```

If the argument is not a valid regular expression it will be transformed into
one, `abc` is transformed into `/^abc$/`.

<<ReadmeTester\ExpectOutput('abc')>>
```php
echo "abc";
```

### Linking examples together

An example may include a previous example using the `Import` attribute, this
will copy the code of the includeed example into the current.

<<ReadmeTester\Example('parent')>>
```php
$data = 'parent-data';
```

Now we can include the named example `parent`.

<<ReadmeTester\Import('parent')>>
<<ReadmeTester\ExpectOutput('parent-data')>>
```php
echo $data;
```

### Hidden examples

Sometimes you may need to set up an environment to create a context for your
examples to run in. This can be done using hidden examples. Hidden examples are
defined inside a html comment. Consider the following example:


    <!--
    <<ReadmeTester\Example('my-hidden-example')>>

    ```php
    // Som setup...
    $var = 'foobar';
    ```
    -->

<<ReadmeTester\Import('my-hidden-example')>>
<<ReadmeTester\ExpectOutput('foobar')>>
```php
echo $var;
```

### Creating a default example context

If you want every example in a readme to include a base context you can use
the `ExampleContext` attribute as in the following example.

<<ReadmeTester\ExampleContext>>
```php
$context = 'setup...';
```

<<ReadmeTester\ExpectOutput('/setup/')>>
```php
echo $context;
```

The command line tool
---------------------
Using the command line tool is as simple as

```shell
vendor/bin/readme-tester README.md
```

For more detailed information use

```shell
vendor/bin/readme-tester -h
```
