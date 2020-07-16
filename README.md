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

## Installation

Install using composer

```shell
composer require --dev hanneskod/readme-tester
```

## The command line tool

Using the command line tool is as simple as

```shell
vendor/bin/readme-tester README.md
```

For more detailed information use

```shell
vendor/bin/readme-tester -h
```
