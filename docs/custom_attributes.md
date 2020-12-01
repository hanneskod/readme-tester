# Custom attributes

Extend readmetester with custom attributes by implementing the
`AttributeInterface` and possibly `TransformationInterface` interfaces.

See [HelloWorldAttribute.php](HelloWorldAttribute.php) for a completely useless way of replacing
the content of a  php example.


    <!--
    #[HelloWorldAttribute]
    #[ReadmeTester\ExpectOutput("hello world")]
    -->
    ```php
    // this example will echo "helo world" as the HelloWorld attribute will replace
    // its content...
    ```
