<?php
namespace hanneskod\exemplify;

/**
 * Exemplify exemplified
 *
 * Two simple test cases. See `tests/ExamplesTest.php` for the examples source.
 */
class ExamplesTest extends TestCase
{
    /**
     * Validate you examples
     * 
     * @before To validate you examples some condition must be asserted. Use the
     *     `expectedOutputString` annotation for simple output validation.
     *
     * @after  To add descriptive messages before and after the code block use
     *     the `before` and `after` annotations respectively.
     *
     * @expectOutputString foobar
     */
    public function exampleTwo()
    {
        echo "foo";
        if (true) {
            echo "bar";
        }
    }    

    /**
     * Testing using regular expressions
     *
     * When writing tests where content is variable you can validate the example
     * using a regular expression instead of a fixed string
     * 
     * @after As this examples illustrates the docblck long description can be
     *     used instead of the `before` tag.
     *
     * @expectOutputRegex /\d{8}/
     */
    public function exampleOne()
    {
        $date = new \DateTime();
        echo $date->format('Ymd');
    }    
}
