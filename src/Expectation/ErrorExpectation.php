<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Validate that correct error is produced
 */
class ErrorExpectation implements ExpectationInterface
{
    /**
     * @var Regexp Expression matching error
     */
    private $regexp;

    /**
     * Set regular expression matching error
     */
    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    public function __tostring(): string
    {
        return "expecting error to match regexp {$this->regexp}";
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return $outcome->getType() == OutcomeInterface::TYPE_ERROR;
    }

    public function handle(OutcomeInterface $outcome): Status
    {
        if (!$this->regexp->isMatch($outcome->getContent())) {
            return new Failure(
                "Failed asserting that error '{$outcome->getContent()}' matches {$this->regexp}"
            );
        }

        return new Success("Asserted that error '{$outcome->getContent()}' matches {$this->regexp}");
    }
}
