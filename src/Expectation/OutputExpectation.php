<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\Result;

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
     */
    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Validate that correct output is produced
     */
    public function validate(Result $result): Status
    {
        if (!$this->regexp->isMatch($result->getOutput())) {
            return new Failure(
                "Failed asserting that output '{$result->getOutput()}' matches {$this->regexp}"
            );
        }

        return new Success("Asserted that output '{$result->getOutput()}' matches {$this->regexp}");
    }
}
