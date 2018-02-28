<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

/**
 * Output from an executed code block
 */
class OutputOutcome implements OutcomeInterface
{
    /**
     * @var string
     */
    private $output;

    public function __construct(string $output)
    {
        $this->output = $output;
    }

    public function getType(): string
    {
        return self::TYPE_OUTPUT;
    }

    public function mustBeHandled(): bool
    {
        return true;
    }

    public function getContent(): string
    {
        return $this->output;
    }

    public function __tostring(): string
    {
        return "output '{$this->output}'";
    }
}
