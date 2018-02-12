<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

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

    public function __tostring(): string
    {
        return "expecting return value to match regexp {$this->regexp}";
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return $outcome->getType() == OutcomeInterface::TYPE_RETURN;
    }

    public function handle(OutcomeInterface $outcome): Status
    {
        $returnValue = $outcome->getPayload()['value'] ?? '';

        if (!$this->regexp->isMatch($returnValue)) {
            return new Failure(
                "Failed asserting that return value '$returnValue' matches {$this->regexp}"
            );
        }

        return new Success("Asserted that return value '$returnValue' matches {$this->regexp}");
    }
}
