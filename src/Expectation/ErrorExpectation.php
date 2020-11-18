<?php

declare(strict_types = 1);

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
        return $outcome->getType() == OutcomeInterface::TYPE_ERROR;
    }

    public function handle(OutcomeInterface $outcome): StatusInterface
    {
        $msg = "that error '{$outcome->getTruncatedContent()}' matches '{$this->regexp->getRegexp()}'";

        if (!$this->regexp->matches($outcome->getContent())) {
            return new Failure("Failed asserting $msg");
        }

        return new Success("Asserted $msg");
    }
}
