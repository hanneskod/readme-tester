# Readme-Tester

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/readme-tester.svg?style=flat-square)](https://packagist.org/packages/hanneskod/readme-tester)
[![Build Status](https://img.shields.io/travis/hanneskod/readme-tester/master.svg?style=flat-square)](https://travis-ci.com/github/hanneskod/readme-tester)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/readme-tester.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/readme-tester)

Validate PHP code examples in markdown files.

## Why?

Did you update your library, but forgot to update code examples in README? Are
your users complaining on syntax errors in your examples? Do you find it too
cumbersome to manually test all examples? Then readme-tester is for you!
Readme-tester lets you automate the process of validating PHP code examples in
markdown files.

## Example

```
#[ReadmeTester\ExpectOutput('/foo/')]
```
```php
echo "foobar";
```

## Installation

### As a phar archive (recommended)

Download the latest phar archive from the
[releases](https://github.com/hanneskod/readme-tester/releases) tab.

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

If composer is not installed as `composer` you can use something like

```shell
make COMPOSER_CMD=./composer.phar
```

## The command line tool

Using the command line tool is as simple as

```shell
readme-tester README.md
```

For more detailed information use

```shell
readme-tester -h
```

## Getting started

[Read the documentation](/docs)
