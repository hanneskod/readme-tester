<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

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

    public function __tostring(): string
    {
        return "expecting output to match regexp {$this->regexp}";
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return $outcome->getType() == OutcomeInterface::TYPE_OUTPUT;
    }

    public function handle(OutcomeInterface $outcome): Status
    {
        if (!$this->regexp->isMatch($outcome->getContent())) {
            return new Failure(
                "Failed asserting that output '{$outcome->getContent()}' matches {$this->regexp}"
            );
        }

        return new Success("Asserted that output '{$outcome->getContent()}' matches {$this->regexp}");
    }
}
