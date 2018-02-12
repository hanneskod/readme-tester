<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\Result;

/**
 * Validate that the correct exception is thrown
 */
class ExceptionExpectation implements ExpectationInterface
{
    /**
     * @var string Name of expected exception class
     */
    private $exceptionClass;

    /**
     * Load name of expected exception class
     */
    public function __construct(string $exceptionClass)
    {
        $this->exceptionClass = $exceptionClass;
    }

    /**
     * Validate that the correct exception is thrown
     */
    public function validate(Result $result): Status
    {
        $exception = $result->getException();

        if (is_null($exception)) {
            return new Failure("Failed asserting that exception {$this->exceptionClass} was thrown");
        }

        if (!$exception instanceof $this->exceptionClass) {
            return new Failure(
                "Failed asserting that exception {$this->exceptionClass} was thrown, found: ".get_class($exception)
            );
        }

        return new Success("Asserted that exception {$this->exceptionClass} was thrown");
    }
}
