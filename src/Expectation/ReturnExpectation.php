<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use UnexpectedValueException;

/**
 * Validate that correct data is returned
 */
class ReturnExpectation implements ExpectationInterface
{
    /**
     * @var Regexp Expression matching return value
     */
    private $regexp;

    /**
     * Set regular expression matching return value
     *
     * @param Regexp $regexp
     */
    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Validate that correct value is returned
     *
     * @param  Result $result
     * @return null
     * @throws UnexpectedValueException If return value does not match regular expression
     */
    public function validate(Result $result)
    {
        $return = $this->makeString($result->getReturnValue());

        if (!$this->regexp->isMatch($return)) {
            throw new UnexpectedValueException(
                "Failed asserting that return value matches {$this->regexp}"
            );
        }
    }

    private function makeString($value)
    {
        if (is_scalar($value)) {
            return (string)$value;
        } elseif (is_null($value)) {
            return '';
        } elseif (is_object($value) && method_exists($value, '__toString' )) {
            return (string)$value;
        }

        throw new UnexpectedValueException("Unable to convert return value into string");
    }
}
