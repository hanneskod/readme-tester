<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Utils\Regexp;

/**
 * Validate that correct output is produced
 */
final class OutputExpectation implements ExpectationInterface
{
    private Regexp $regexp;

    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    public function getDescription(): string
    {
        return "expecting output to match regexp {$this->regexp->getRegexp()}";
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return $outcome->isOutput();
    }

    public function handle(OutcomeInterface $outcome): StatusInterface
    {
        $msg = "that output '{$outcome->getContent()}' matches '{$this->regexp->getRegexp()}'";

        if (!$this->regexp->matches($outcome->getContent())) {
            return new Failure($outcome, "Failed asserting $msg");
        }

        return new Success($outcome, "Asserted $msg");
    }
}
