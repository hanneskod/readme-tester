<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Validate the type of the raturn value
 */
class ReturnTypeExpectation implements ExpectationInterface
{
    /**
     * @var string
     */
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function __tostring(): string
    {
        return "expecting return value to be of type {$this->type}";
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return $outcome->getType() == OutcomeInterface::TYPE_RETURN;
    }

    public function handle(OutcomeInterface $outcome): Status
    {
        $returnType = $outcome->getPayload()['type'] ?? '';
        $returnClass = $outcome->getPayload()['class'] ?? '';

        if (0 == strcasecmp($this->type, $returnType) || 0 == strcasecmp($this->type, $returnClass)) {
            return new Success("Asserted return type $this->type");
        }

        return new Failure("Failed asserting return type '{$this->type}', found: $returnType");
    }
}
