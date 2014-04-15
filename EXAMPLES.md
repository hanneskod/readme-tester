# Exemplify exemplified

Two simple test cases. See `tests/ExamplesTest.php` for the examples
source.

## Validate you examples

To validate you examples some condition must be asserted. Use the
`expectedOutputString` annotation for simple output validation.

    echo "foo";
    if (true) {
        echo "bar";
    }

To add descriptive messages before and after the code block use the
`before` and `after` annotations respectively.

## Testing using regular expressions

When writing tests where content is variable you can validate the example
using a regular expression instead of a fixed string

    $date = new \DateTime();
    echo $date->format('Ymd');

As this examples illustrates the docblck long description can be used
instead of the `before` tag.

