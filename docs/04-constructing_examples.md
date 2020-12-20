# Constructing examples

> Examples are constructed by concatenating the contents of imported examples
> (and contexts) and prepending/appending lines using attributes. Use the
> `--debug` option to see how the constructed example looks like.

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

Please note that chaining imports is not supported. Importing `child` from the
previous example will _not_ automatically import `parent`.

    <!--
    #[ReadmeTester\Import('child')]
    #[ReadmeTester\ExpectError('/data/')]
    -->
    ```php
    // Will error as child tries to access an undefined variable $data
    ```

To import a deep structure like this all examples must be specified specifically.

    <!--
    #[ReadmeTester\Import('parent')]
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

## Hidden examples

Sometimes you may need to set up an environment to create a context for your
examples to run in. This can be done using hidden examples. Hidden examples are
defined inside a html comment. Consider the following example:

    <!--
    This example is hidden in a html comment

    #[ReadmeTester\Example('hidden-example')]

    It will not be rendered on for example github..

    ```php
    $hiddenVar = 'foobar';
    ```
    -->

    #[ReadmeTester\Example('import-hidden-example')]
    #[ReadmeTester\Import('hidden-example')]
    #[ReadmeTester\ExpectOutput('foobar')]
    ```php
    echo $hiddenVar;
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
    #[ReadmeTester\UseFunction('print_r', 'output')]
    #[ReadmeTester\UseConst('E_USER_ERROR', 'INTEGER_CONSTANT')]
    #[ReadmeTester\ExpectOutput('/Exception/')]
    #[ReadmeTester\ExpectOutput('/\d+/')]
    -->
    ```php
    output(Foo::class);
    output(INTEGER_CONSTANT);
    ```
