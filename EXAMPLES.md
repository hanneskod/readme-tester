# Usage

## Markdown examples

A class level docblock can start with a short description, wich will be
formatted as a headline, and continue with a long description, wich will be
formatted as normal text. Regular markdown can be used. Here we create a link to
the [source file for these examples](tests/BaseExamples.php).

### Using the before and after annotations

If you omit the short description exemplify will under some conditions interpret
the long description as a headline.

    // void example

Fix this by using the `@before` annotation. As done in this paragraph.

    // void example

In a simliar manner the `@after` annotation may be used to add descripticve text
after the example code block.

## Expectation examples

To enable automated testing of code examples (without cluttering them with
phpunit assert statements) we move the assertions to the docbloc comments.
Exemplify supports a variety of annotations. See the [source
file](tests/ExpectationExamples.php) for a concrete example.

### Expected output

The simplest way to test your example is by validating it's output. Here we use
`@expectOutputString foobar`.

    echo "foo";
    if (true) {
        echo "bar";
    }
    // Outputs foobar

You can also validate the return value. Here we use `@expectReturnString ++++`. 

    return str_repeat('+', 4);
    // returns ++++

### Output using regular expressions

When writing examples where content is variable you can validate using a regular
expression instead of a fixed string. Here we use `@expectOutputRegex /\d{8}/`.

    $date = new \DateTime();
    echo $date->format('Ymd');
    // Outputs something like 20140416

In the same way the return value can be validated using regular expressions.
Here we use `@expectReturnRegex /\d{2}/`.

    return rand(10, 99);
    // returns something like 22

### Expecting exceptions

Here we use `@expectedException \hanneskod\exemplify\Exception` to expect an
exception in the example.

    throw new Exception;
    // Throwing the exception satisfies the expectation

