<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use UnexpectedValueException;

/**
 * Validate that correct output is produced
 */
class OutputExpectation implements ExpectationInterface
{
    /**
     * @var Regexp Expression matching output
     */
    private $regexp;

    /**
     * Set regular expression matching output
     *
     * @param Regexp $regexp
     */
    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Validate that correct output is produced
     *
     * @param  Result $result
     * @return null
     * @throws UnexpectedValueException If output does not match regular expression
     */
    public function validate(Result $result)
    {
        if (!$this->regexp->isMatch($result->getOutput())) {
            throw new UnexpectedValueException(
                "Failed asserting that output '{$result->getOutput()}' matches {$this->regexp}"
            );
        }
    }
}
