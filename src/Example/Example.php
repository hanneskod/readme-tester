<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Parser\CodeBlock;

/**
 * Default example
 */
class Example
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var CodeBlock
     */
    private $code;

    /**
     * @var ExpectationInterface[]
     */
    private $expectations;

    /**
     * @param string                 $name         Name of this example
     * @param CodeBlock              $code         Example code
     * @param ExpectationInterface[] $expectations List of expectations
     */
    public function __construct(string $name, CodeBlock $code, array $expectations)
    {
        $this->name = $name;
        $this->code = $code;
        $this->expectations = $expectations;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function shouldBeEvaluated(): bool
    {
        return true;
    }

    public function getCodeBlock(): CodeBlock
    {
        return $this->code;
    }

    /**
     * @return ExpectationInterface[]
     */
    public function getExpectations(): array
    {
        return $this->expectations;
    }
}
