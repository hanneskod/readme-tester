# Readme-Tester

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/readme-tester.svg?style=flat-square)](https://packagist.org/packages/hanneskod/readme-tester)
[![Build Status](https://img.shields.io/travis/hanneskod/readme-tester/master.svg?style=flat-square)](https://travis-ci.com/github/hanneskod/readme-tester)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/readme-tester.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/readme-tester)

Validate PHP code examples in documentation.

## Why?

Did you update your library, but forgot to update code examples in README? Are
your users complaining on syntax errors in your examples? Do you find it too
cumbersome to manually test all examples? Readme-Tester lets you automate the
process of validating PHP code examples in documentation files.

### A simple example

Readme-Tester uses php8 style attributes inside HTML-comments (to make them
invisible after rendering on for example github) to specify the expected
result of a code example.

The following simple example asserts that the code outputs content.

    <!--
    #[ReadmeTester\ExpectOutput('/foo/')]
    -->
    ```php
    echo "foobar";
    ```

For more information [read the documentation](/docs).

## Installation

### As a phar archive (recommended)

Download the latest phar archive from the [releases][1] tab.

Optionally rename `readme-tester.phar` to `readme-tester` for a smoother experience.

### Through composer

```shell
composer require --dev hanneskod/readme-tester
```

This will make `readme-tester` avaliable as `vendor/bin/readme-tester`.

### From source

To build you need `make`

```shell
make
sudo make install
```

The build script uses [composer][2] to handle dependencies and [phive][3] to
handle build tools. If they are not installed as `composer` or `phive`
respectivly you can use something like

```shell
make COMPOSER_CMD=./composer.phar PHIVE_CMD=./phive.phar
```

## Getting started

Using the command line tool is as simple as

```shell
readme-tester README.md
```

For more detailed information use

```shell
readme-tester -h
```

[1]: <https://github.com/hanneskod/readme-tester/releases>
[2]: <https://getcomposer.org/>
[3]: <https://phar.io/>
