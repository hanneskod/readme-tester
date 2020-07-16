# Example contexts

If you want every example in a file to include a base context you can use
the `ExampleContext` attribute as in the following example.

<<ReadmeTester\ExampleContext>>
```php
$context = 'context';
```

<<ReadmeTester\ExpectOutput('context')>>
```php
echo $context;
```

## Hidden contexts

Contexts may be hidden inside of HTML comments.

    <!--
    <<ReadmeTester\ExampleContext>>
    ```php
    $hiddenContext = 'hidden';
    ```
    -->

<<ReadmeTester\ExpectOutput('hidden')>>
```php
echo $hiddenContext;
```

## Ignored contexts

As contexts often do note perform any testing by themselves they con be ignored
using the `Ignore` attribute.

<<ReadmeTester\Ignore>>
<<ReadmeTester\ExampleContext>>
```php
$ignoredContext = 'ignored';
```

<<ReadmeTester\ExpectOutput('ignored')>>
```php
echo $ignoredContext;
```

## Multiple contexts

Multiple contexts may be defined, as has been done in this file.

<<ReadmeTester\ExpectOutput('contexthiddenignored')>>
```php
echo $context;
echo $hiddenContext;
echo $ignoredContext;
```
