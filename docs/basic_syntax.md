# Basic syntax

When readme-tester validates a file all php code blocks are executed. In
markdown this means using a fenced block with the `php` language
identifier.

    ```php
    // This code is validated
    ```

    ```
    This block is not named with the php language identifier, and is thus not
    executed by readmetester..
    ```


## Attributes

To specify how examples should be tested readme-tester uses php attributes.
Attributes found in a file are applied to the next php code block found after
the attribute. Unknown attributes are ignored.

Attributes may be hidden inside HTML comments, to make sure that instructions
related to testing are not rendered on github or similar.

A set of attributes may look like this

```
#[ReadmeTester\Example('name')]
#[ReadmeTester\ExpectOutput('/code/')]
```

Or like this

```
<!--
#[ReadmeTester\Example('name')]
#[ReadmeTester\ExpectOutput('/code/')]
-->
```

Putting it all together the standard way would be to combine attributes inside
of an HTML comment block with a fenced block of php code.


    <!--
    #[ReadmeTester\Example("simple-example-with-attribute")]
    -->
    ```php
    echo "this code is validated";
    ```

### Unknown attributes

Attributes unknown to readmetester are simply skipped

    // TODO commented out, should work once propper php8 attributes is used
    ##[UnknownAttribute]
    ```php
    // The UnknownAttribute is skipped as it is not known
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

## PHP mode

By default examples start in php mode, meaning that no `<?php` opening tag is
needed. Use `StartInHtmlMode` to alter this behaviour.

    #[ReadmeTester\StartInHtmlMode]
    #[ReadmeTester\ExpectOutput("/html/")]
    ```php
    this example started in html mode
    ```
