<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Parser\CodeBlock;

class Example implements ExampleInterface
{
    /** @var NameInterface */
    private $name;

    /** @var CodeBlock */
    private $code;

    /** @var ExpectationInterface[] */
    private $expectations;

    /**
     * @param ExpectationInterface[] $expectations
     */
    public function __construct(NameInterface $name, CodeBlock $code, array $expectations)
    {
        $this->name = $name;
        $this->code = $code;
        $this->expectations = $expectations;
    }

    public function getName(): NameInterface
    {
        return $this->name;
    }

    public function isActive(): bool
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
