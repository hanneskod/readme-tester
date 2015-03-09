Exemplify
=========

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/exemplify.svg?style=flat-square)](https://packagist.org/packages/hanneskod/exemplify)
[![Build Status](https://img.shields.io/travis/hanneskod/exemplify/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/exemplify)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/exemplify.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/exemplify)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/exemplify.svg?style=flat-square)](https://gemnasium.com/hanneskod/exemplify)

Validate code examples in readme files

Why?
----
No more erroneous examples in `README.md`, let phpunit tell you when your examples
are out of date!

Installation
------------
```shell
composer require --dev hanneskod/exemplify
```

Usage
-----
<!-- @expectOutput output -->
<!-- @ignore -->
```php
echo "foobar";
```
<!-- @expectOutput output -->
```php
echo "foobar";
```

### Phpunit integration

If you are using PHPUnit's XML configuration approach, you can include the following
to integrate testing `README.md` with phpunit.

```xml
<listeners>
    <listener class="\hanneskod\readmetester\Phpunit\TestListener">
        <arguments>
            <string>README.md</string>
        </arguments>
    </listener>
</listeners>
```

Make sure Composer's autoloader is present in the bootstrap file or you will need
to also define a "file" attribute pointing to the file of the `TestListener` class.

Credits
-------
Exemplify is covered under the [WTFPL](http://www.wtfpl.net/)

@author Hannes Forsgård (hannes.forsgard@fripost.org)
