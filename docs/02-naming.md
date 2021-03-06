# Naming examples

All examples can be referd to by a unique name with the form `namespace:name`.
Set the namespace and name parts using the `ReadmeTester\NamespaceName` and
`ReadmeTester\Name` attributes.

<!--
#[ReadmeTester\IgnoreOutput]
-->

    <!--
    #[ReadmeTester\NamespaceName("Foo")]
    #[ReadmeTester\Name("Bar")]
    -->
    ```php
    echo "This example can be referenced using Foo:Bar";
    ```

By default the namespace is set to the current filename.

<!--
#[ReadmeTester\IgnoreOutput]
-->

    <!--
    #[ReadmeTester\Name("Baz")]
    -->
    ```php
    echo "This example can be referenced using naming.md:Baz";
    ```

> NOTE that the file path used as default namespace depends on the current
> working directory from where Readme-Tester is executed.

## Headers as example names

If not named explicitly the first example following a header will be named after
said header.

<!--
#[ReadmeTester\IgnoreOutput]
-->

    ```php
    echo "This example can be referenced using naming.md:Headers-as-example-names";
    ```

## Naming using the Example attribute

The Example attribute may specify a name.

<!--
#[ReadmeTester\IgnoreOutput]
-->

    <!--
    #[ReadmeTester\Example("example-name")]
    -->
    ```php
    echo "This example can be referenced using naming.md:example-name";
    ```

<!--
This hidden block is intended to validate that blocks are really named as described..

#[ReadmeTester\Example("Test namespaced name")]
#[ReadmeTester\Import("Foo:Bar")]
#[ReadmeTester\ExpectOutput("/Foo:Bar/")]
```php
```

#[ReadmeTester\Example("Test default namespace")]
#[ReadmeTester\Import("Baz")]
#[ReadmeTester\ExpectOutput("/naming.md:Baz/")]
```php
```

#[ReadmeTester\Example("Test header name")]
#[ReadmeTester\Import("Headers-as-example-names")]
#[ReadmeTester\ExpectOutput("/naming.md:Headers-as-example-names/")]
```php
```

#[ReadmeTester\Example("Test example attribute")]
#[ReadmeTester\Import("example-name")]
#[ReadmeTester\ExpectOutput("/naming.md:example-name/")]
```php
```
-->
