<!--
<<ReadmeTester\NamespaceName("global")>>
-->

# Global attributes

Global attributes are attributes that apply to all examples in a file. Specify
global attributes by putting an html comment block containg attributes on the
first line.

This file starts with

```
<!--
<<ReadmeTester\NamespaceName("global")>>
-->
```

This is the logical equivalent to applying the NamespaceName atttribute to every
eample in this file. The following example will automatically be in the _global_
namespace.

```php
// In the global namespace
```

<!--
This hidden block is intended to validate that global attributes are applied

<<ReadmeTester\Example("to-import")>>
<<ReadmeTester\Ignore>>
```php
echo "global";
```

<<ReadmeTester\Example("Test global namespace")>>
<<ReadmeTester\Import("global:to-import")>>
<<ReadmeTester\ExpectOutput("global")>>
```php
```
-->
