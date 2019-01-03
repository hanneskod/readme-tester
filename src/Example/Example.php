<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Utils\CodeBlock;

final class Example implements ExampleInterface
{
    /** @var bool */
    private $active = true;

    /** @var NameInterface */
    private $name;

    /** @var CodeBlock */
    private $code;

    /** @var ExpectationInterface[] */
    private $expectations;

    /**
     * @param ExpectationInterface[] $expectations
     */
    public function __construct(NameInterface $name, CodeBlock $code, array $expectations = [])
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
        return $this->active;
    }

    public function withActive(bool $active): ExampleInterface
    {
        $new = clone $this;
        $new->active = $active;
        return $new;
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
