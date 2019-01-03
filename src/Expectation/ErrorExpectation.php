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
    /** @var Regexp */
    private $regexp;

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
        if (!$this->regexp->isMatch($outcome->getContent())) {
            return new Failure(
                "Failed asserting that error '{$outcome->getContent()}' matches {$this->regexp->getRegexp()}"
            );
        }

        return new Success("Asserted that error '{$outcome->getContent()}' matches {$this->regexp->getRegexp()}");
    }
}
