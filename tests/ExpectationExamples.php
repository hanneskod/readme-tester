<?php
namespace hanneskod\exemplify;

/**
 * Expectation examples
 *
 * To enable automated testing of code examples (without cluttering them with
 * phpunit assert statements) we move the assertions to the docbloc comments.
 * Exemplify supports a variety of annotations.
 */
class ExpectationExamples extends TestCase
{
    /**
     * Expected output
     * 
     * The simplest way to test your example is by validating it's output. Here
     * we use `@expectOutputString foobar`. 
     *
     * @expectOutputString foobar
     */
    public function exampleStringOutput()
    {
        echo "foo";
        if (true) {
            echo "bar";
        }
        // Outputs foobar
    }    

    /**
     * @before You can also validate the return value. Here we use
     *     `@expectReturnString ++++`. 
     *
     * @expectReturnString ++++
     */
    public function exampleStringReturn()
    {
        return str_repeat('+', 4);
        // returns ++++
    }    

    /**
     * Output using regular expressions
     *
     * When writing examples where content is variable you can validate
     * using a regular expression instead of a fixed string. Here we use
     * `@expectOutputRegex /\d{8}/`.
     * 
     * @expectOutputRegex /\d{8}/
     */
    public function exampleRegexOutput()
    {
        $date = new \DateTime();
        echo $date->format('Ymd');
        // Outputs something like 20140416
    }    

    /**
     * @before In the same way the return value can be validated using regular
     *     expressions. Here we use `@expectReturnRegex /\d{2}/`.
     * 
     * @expectReturnRegex /\d{2}/
     */
    public function exampleRegexReturn()
    {
        return rand(10, 99);
        // returns something like 22
    }    

    /**
     * Expecting exceptions
     *
     * Here we use `@expectedException \hanneskod\exemplify\Exception` to
     * expect an exception in the example.
     * 
     * @expectedException \hanneskod\exemplify\Exception
     */
    public function exampleExpectedException()
    {
        throw new Exception;
        // Throwing the exception satisfies the expectation
    }    
}
