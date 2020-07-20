# Custom attributes

Extend readmetester with custom attributes by implementing the
`TransformationInterface` interface.

See [HelloWorld.php](HelloWorld.php) for a completely useless way of replacing
the content of a  php example.

    <<HelloWorld>>
    <<ReadmeTester\ExpectOutput("hello world")>>
    ```php
    // this example will echo "helo world" as the HelloWorld attribute will replace
    // its content...
    ```
