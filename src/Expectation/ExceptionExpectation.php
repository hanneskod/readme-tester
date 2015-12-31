<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use UnexpectedValueException;

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
     *
     * @param string $exceptionClass
     */
    public function __construct($exceptionClass)
    {
        $this->exceptionClass = $exceptionClass;
    }

    /**
     * Validate that the correct exception is thrown
     *
     * @param  Result $result
     * @return null
     * @throws UnexpectedValueException If exception is not thrown
     */
    public function validate(Result $result)
    {
        $exception = $result->getException();

        if (is_null($exception)) {
            throw new UnexpectedValueException("Failed asserting that exception {$this->exceptionClass} is thrown");
        }

        if (!$exception instanceof $this->exceptionClass) {
            throw new UnexpectedValueException(
                "Failed asserting that exception {$this->exceptionClass} is thrown, found: " . get_class($exception)
            );
        }
    }
}
