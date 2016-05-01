<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

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
     */
    public function validate(Result $result)
    {
        if (!$this->regexp->isMatch($result->getOutput())) {
            return new ReturnObj\Failure(
                "Failed asserting that output '{$result->getOutput()}' matches {$this->regexp}"
            );
        }

        return new ReturnObj\Success("Asserted that output '{$result->getOutput()}' matches {$this->regexp}");
    }
}
