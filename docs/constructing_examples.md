# Constructing examples

## Importing

An example may import the contents of another example using the `Import`
attribute.

    <!--
    #[ReadmeTester\Example('parent')]
    -->
    ```php
    $data = 'parent-data';
    ```

Here example `child` imports `parent`

    <!--
    #[ReadmeTester\Example('child')]
    #[ReadmeTester\Import('parent')]
    #[ReadmeTester\ExpectOutput('parent-data')]
    -->
    ```php
    echo $data;
    ```

### Chaining imports

TODO
aha,
är det här en bugg?
Det här borde väll implicit betyda att parent också importeras!!

Tillfällig ignore..
#[ReadmeTester\Ignore]

    <!--
    #[ReadmeTester\Import('child')]
    #[ReadmeTester\ExpectOutput('parent-data')]
    -->
    ```php
    ```

### Multiple imports

Defining an example `A`...

    <!--
    #[ReadmeTester\Example('A')]
    -->
    ```php
    $A = 'A';
    ```

...and an example `B`...

    <!--
    #[ReadmeTester\Example('B')]
    -->
    ```php
    $B = 'B';
    ```

...and importing both works as expected.

    <!--
    #[ReadmeTester\Example('import-A-B')]
    #[ReadmeTester\Import('A')]
    #[ReadmeTester\Import('B')]
    #[ReadmeTester\ExpectOutput('/AB/')]
    -->
    ```php
    echo $A, $B;
    ```

## Adding code

You may also prepend or append code to the example using the `PrependCode` and
`AppendCode` attributes.

    <!--
    #[ReadmeTester\PrependCode("echo 'foo ';")]
    #[ReadmeTester\AppendCode("echo ' baz';")]
    #[ReadmeTester\ExpectOutput('foo bar baz')]
    -->
    ```php
    echo "bar";
    ```

### Setting the PHP parsing mode

By default examples start in php mode, meaning that no `<?php` opening tag is
needed. Use `StartInHtmlMode` to alter this behaviour.

    <!--
    #[ReadmeTester\StartInHtmlMode]
    #[ReadmeTester\ExpectOutput("/html/")]
    -->
    ```php
    this example started in html mode
    ```

### Setting the PHP namespace

If you don't wish to clutter examples with namespace declarations you can use
the `StartInPhpNamespace` attribute.

    <!--
    #[ReadmeTester\StartInPhpNamespace('foobar')]
    #[ReadmeTester\ExpectOutput('/foobar/')]
    -->
    ```php
    echo __NAMESPACE__;
    ```

### Importing symbols

Yoy may also import symbols into the example by prepending `use` declarations
using the `UseClass`, `UseFunction` and `UseConst` attributes. All take
the name of the symbol to import and an optional local name as arguments.

    <!--
    #[ReadmeTester\UseClass('Exception', 'Foo')]
    #[ReadmeTester\UseFunction('var_dump', 'output')]
    #[ReadmeTester\UseConst('E_USER_ERROR', 'INTEGER_CONSTANT')]
    #[ReadmeTester\ExpectOutput('/Exception/')]
    #[ReadmeTester\ExpectOutput('/int\(\d+\)/')]
    -->
    ```php
    output(Foo::class);
    output(INTEGER_CONSTANT);
    ```
