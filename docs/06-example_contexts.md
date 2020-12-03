# Example contexts

If you want every example in a file to include a base context you can use
the `ExampleContext` attribute as in the following example.

    <!--
    #[ReadmeTester\ExampleContext]
    -->
    ```php
    $context = 'context';
    ```

The example context will be imported automatically

    <!--
    #[ReadmeTester\ExpectOutput('context')]
    -->
    ```php
    echo $context;
    ```

## Hidden contexts

Contexts may be hidden inside of HTML comments.

    <!--
    #[ReadmeTester\ExampleContext]
    ```php
    $hiddenContext = 'hidden';
    ```
    -->

Works as expected.

    <!--
    #[ReadmeTester\ExpectOutput('hidden')]
    -->
    ```php
    echo $hiddenContext;
    ```

## Ignored contexts

As contexts often do note perform any testing by themselves they con be ignored
using the `Ignore` attribute.

    <!--
    #[ReadmeTester\Ignore]
    #[ReadmeTester\ExampleContext]
    -->
    ```php
    $ignoredContext = 'ignored';
    ```

They will still be used as contexts the normal way.

    <!--
    #[ReadmeTester\ExpectOutput('ignored')]
    -->
    ```php
    echo $ignoredContext;
    ```

## Multiple contexts

Multiple contexts may be defined, as has been done in this file.

    <!--
    #[ReadmeTester\ExpectOutput('contexthiddenignored')]
    -->
    ```php
    echo $context;
    echo $hiddenContext;
    echo $ignoredContext;
    ```

## Explicitly importing an example context

Importing a named context is not neccesary, but works as eccpected.

    <!--
    #[ReadmeTester\Name('named-example-context')]
    #[ReadmeTester\ExampleContext]
    -->
    ```php
    $namedExampleContextImportTimes = ($namedExampleContextImportTimes ?? 0) + 1;
    ```

Explicitly importing the context will only include it once.

    <!--
    #[ReadmeTester\Name('importing-named-example-context')]
    #[ReadmeTester\Import('named-example-context')]
    #[ReadmeTester\ExpectOutput('1')]
    -->
    ```php
    echo $namedExampleContextImportTimes;
    ```
