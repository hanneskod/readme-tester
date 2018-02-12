<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Validate that the correct exception is thrown
 */
class ExceptionExpectation implements ExpectationInterface
{
    /**
     * @var string Name of expected exception class
     */
    private $exceptionClass;

    public function __construct(string $exceptionClass)
    {
        $this->exceptionClass = $exceptionClass;
    }

    public function __tostring(): string
    {
        return "expecting an exception of class {$this->exceptionClass} to be thrown";
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return $outcome->getType() == OutcomeInterface::TYPE_EXCEPTION;
    }

    public function handle(OutcomeInterface $outcome): Status
    {
        $thrownClass = $outcome->getPayload()['class'] ?? '';

        if ($thrownClass != $this->exceptionClass) {
            return new Failure(
                "Failed asserting that exception {$this->exceptionClass} was thrown, found: $thrownClass"
            );
        }

        return new Success("Asserted that exception {$this->exceptionClass} was thrown");
    }
}
