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
        if (!$this->regexp->isMatch($result->getReturnValue())) {
            throw new UnexpectedValueException(
                "Failed asserting that return value '{$result->getReturnValue()}' matches {$this->regexp}"
            );
        }
    }
}
