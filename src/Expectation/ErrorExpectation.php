<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Utils\Regexp;

/**
 * Validate that correct error is produced
 */
final class ErrorExpectation implements ExpectationInterface
{
    private Regexp $regexp;

    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    public function getDescription(): string
    {
        return "expecting error to match regexp {$this->regexp->getRegexp()}";
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return $outcome->isError();
    }

    public function handle(OutcomeInterface $outcome): StatusInterface
    {
        $msg = "that error '{$outcome->getContent()}' matches '{$this->regexp->getRegexp()}'";

        if (!$this->regexp->matches($outcome->getContent())) {
            return new Failure($outcome, "Failed asserting $msg");
        }

        return new Success($outcome, "Asserted $msg");
    }
}
