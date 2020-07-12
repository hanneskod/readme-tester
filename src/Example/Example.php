<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Utils\Name;
use hanneskod\readmetester\Utils\CodeBlock;

final class Example implements ExampleInterface
{
    private bool $active = true;
    private bool $context = false;

    private CodeBlock $code;
    private Name $name;

    /** @var array<object> */
    private array $attributes;

    /** @var array<ExpectationInterface> */
    private array $expectations = [];

    /** @var array<Name> */
    private array $imports = [];

    /**
     * @param array<object> $attributes
     */
    public function __construct(Name $name, CodeBlock $code, array $attributes = [])
    {
        $this->name = $name;
        $this->code = $code;
        $this->attributes = $attributes;
    }

    public function getAttributes(): iterable
    {
        return $this->attributes;
    }

    public function getCodeBlock(): CodeBlock
    {
        return $this->code;
    }

    public function getExpectations(): iterable
    {
        return $this->expectations;
    }

    public function getImports(): iterable
    {
        return $this->imports;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isContext(): bool
    {
        return $this->context;
    }

    public function withActive(bool $active): ExampleInterface
    {
        $new = clone $this;
        $new->active = $active;
        return $new;
    }

    public function withCodeBlock(CodeBlock $code): ExampleInterface
    {
        $new = clone $this;
        $new->code = $code;
        return $new;
    }

    public function withExpectation(ExpectationInterface $expectation): ExampleInterface
    {
        $new = clone $this;
        $new->expectations[] = $expectation;
        return $new;
    }

    public function withImport(Name $name): ExampleInterface
    {
        $new = clone $this;
        $new->imports[] = $name;
        return $new;
    }

    public function withIsContext(bool $flag): ExampleInterface
    {
        $new = clone $this;
        $new->context = $flag;
        return $new;
    }

    public function withName(Name $name): ExampleInterface
    {
        $new = clone $this;
        $new->name = $name;
        return $new;
    }
}
