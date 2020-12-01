<!--
#[ReadmeTester\Isolate]
-->

# Isolation

Readmetester can use different runners to execute examples. The default runner
executes all examples in isolation. This makes for a solid testing experience,
but is slow..

A faster alternative is the `eval` runner that executes examples by including
them in the current environment. This is much faster, but failes if two examples
define the same symbol. The following is perfectly valid, but will fail using
the eval runner as the context is included in both examples.

    <!--
    #[ReadmeTester\ExampleContext]
    -->
    ```php
    function a_function_included_in_all_examples() {}
    ```

An example that imports context.

    ```php
    // imports a_function_included_in_all_examples() from example context
    ```

A second example that imports context.

    ```php
    // also imports a_function_included_in_all_examples() from example context
    // fails if not executed in isolation
    ```

Here is another example that will fail using the `eval` runner, as the same symbol
is both in `parent` and then imported once again into `child`.

    <!--
    #[ReadmeTester\Name('parent')]
    -->
    ```php
    function parent_function() {}
    ```

Import `parent` into `child`

    <!--
    #[ReadmeTester\Name('child')]
    #[ReadmeTester\Import('parent')]
    -->
    ```php
    // imports parent_function() from parent
    // fails if not executed in isolation as parent has also been validated
    ```

Use the `Isolate` attribute to require that an example be executed in isolation.
This will force the example to be skipped by runners that does not support
isolation.

    <!--
    #[ReadmeTester\Isolate]
    #[ReadmeTester\Name('child-that-requires-isolation')]
    #[ReadmeTester\Import('parent')]
    -->
    ```php
    // imports parent_function() from parent
    // isolation forced by #[ReadmeTester\Isolate]
    ```
