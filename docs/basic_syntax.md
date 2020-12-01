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

> A note on the syntax used in these files: Examples and attribute blocks are
> indented to make the acctual syntax visible. In the real world you would
> not indent and thus would code block fences and attributes inside
> HTML-comments and not render on for example github.

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

    <!--
    #[UnknownAttribute]
    -->
    ```php
    // The UnknownAttribute is skipped as it is not known
    ```

### Case insensitive attributes

Attributes are case insensitive.

    <!--
    #[readmetester\expectoutput('foo')]
    -->
    ```php
    echo "foo";
    ```

### Multiple attributes

Multiple attributes can be grouped togheter in the same way as php handles
native attributes.

    <!--
    #[
        ReadmeTester\ExpectOutput('/foo/'),
        ReadmeTester\ExpectOutput('/bar/')
    ]
    -->
    ```php
    echo "foobar";
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
