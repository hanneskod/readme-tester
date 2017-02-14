<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

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
     */
    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Validate that correct value is returned
     */
    public function validate(Result $result): ReturnObj\ReturnObj
    {
        $return = $this->makeString($result->getReturnValue());

        if (!$this->regexp->isMatch($return)) {
            return new ReturnObj\Failure(
                "Failed asserting that return value matches {$this->regexp}"
            );
        }

        return new ReturnObj\Success("Asserted that return value matches {$this->regexp}");
    }

    private function makeString($value): string
    {
        if (is_scalar($value)) {
            return (string)$value;
        } elseif (is_null($value)) {
            return '';
        } elseif (is_object($value) && method_exists($value, '__toString')) {
            return (string)$value;
        }

        throw new \UnexpectedValueException("Unable to convert return value into string");
    }
}
