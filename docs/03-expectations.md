# Expectations

Add assertions to code blocks using one of the expectation attributes.
Multiple expectations can be specified for an example.

## Asserting state

Use the `Assert` attbitue to add a custom assertion to the example
(as if written with PHPs *assert()* method).

    <!--
    #[ReadmeTester\Assert('$shouldBeTrue')]
    --->
    ```php
    $shouldBeTrue = true;
    ```

Failed assertions triggers an error

    <!--
    #[ReadmeTester\Assert('$shouldBeTrue')]
    #[ReadmeTester\IgnoreError]
    -->
    ```php
    $shouldBeTrue = false;
    ```

## Expecting output

Assert the output of an example using a regular expression.

    <!--
    #[ReadmeTester\Name('expecting-output-using-a-regular-expression')]
    #[ReadmeTester\ExpectOutput('/regular expression/')]
    -->
    ```php
    echo "This output is matched using a regular expression";
    ```

If the argument is not a valid regular expression it will be transformed into
one, `abc` is transformed into `/^abc$/`.

    <!--
    #[ReadmeTester\Name('expecting-output-using-a-string')]
    #[ReadmeTester\ExpectOutput('abc')]
    -->
    ```php
    echo "abc";
    ```

## Ignoring output

The `IgnoreOutput` attribute acts as shorthand to expect any output.

    <!--
    #[ReadmeTester\IgnoreOutput]
    -->
    ```php
    echo 'abc';
    ```

## Expecting errors

You can expect regular errors...

    <!--
    #[ReadmeTester\Name('expecting-an-error')]
    #[ReadmeTester\ExpectError('/this_function_does_not_exist/')]
    --->
    ```php
    this_function_does_not_exist();
    ```
...exceptions...

    <!--
    #[ReadmeTester\Name('expecting-an-exception')]
    #[ReadmeTester\ExpectError('/RuntimeException/')]
    -->
    ```php
    throw new RuntimeException;
    ```

...user errors (here we use `IgnoreError` which is a shorthand to expect any error)...

    <!--
    #[ReadmeTester\Name('ignoring-an-error')]
    #[ReadmeTester\IgnoreError]
    -->
    ```php
    trigger_error("this-should-be-ignored");
    ```

...and php parsing errors.

    <!--
    #[ReadmeTester\Name('expecting-a-syntax-error')]
    #[ReadmeTester\ExpectError('/syntax/')]
    -->
    ```php
    this is not valid php..
    ```

### Errors precede output

If an example produces both output and errors only the error can be asserted.

    #[ReadmeTester\ExpectError('/error/')]
    ```php
    echo "this will output";
    trigger_error("but here is an error");
    ```

### Suppressing php errors

You may suppress errors using the `@` error control operator as in normal PHP code.

    #[ReadmeTester\ExpectOutput('1')]
    ```php
    echo @$thisVarIsNotDefined + 1;
    ```

Without the `@` operator the same code would result in an error.

    #[ReadmeTester\ExpectError('/thisVarIsNotDefined/')]
    ```php
    echo $thisVarIsNotDefined + 1;
    ```
