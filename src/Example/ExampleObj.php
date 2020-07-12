<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Utils\NameObj;
use hanneskod\readmetester\Utils\CodeBlock;

class ExampleObj
{
    private bool $active = true;
    private bool $context = false;

    private CodeBlock $code;
    private NameObj $name;

    /** @var array<object> */
    private array $attributes;

    /** @var array<ExpectationInterface> */
    private array $expectations = [];

    /** @var array<NameObj> */
    private array $imports = [];

    /**
     * @param array<object> $attributes
     */
    public function __construct(NameObj $name, CodeBlock $code, array $attributes = [])
    {
        $this->name = $name;
        $this->code = $code;
        $this->attributes = $attributes;
    }

    /**
     * @return array<object>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get example code block
     */
    public function getCodeBlock(): CodeBlock
    {
        return $this->code;
    }

    /**
     * @return array<ExpectationInterface>
     */
    public function getExpectations(): array
    {
        return $this->expectations;
    }

    /**
     * @return array<NameObj>
     */
    public function getImports(): array
    {
        return $this->imports;
    }

    /**
     * Get example name
     */
    public function getName(): NameObj
    {
        return $this->name;
    }

    /**
     * Check if example is active, eg. should be evaluated
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Check of thes example should work as a context for other examples
     */
    public function isContext(): bool
    {
        return $this->context;
    }

    public function withActive(bool $active): ExampleObj
    {
        $new = clone $this;
        $new->active = $active;
        return $new;
    }

    public function withCodeBlock(CodeBlock $code): ExampleObj
    {
        $new = clone $this;
        $new->code = $code;
        return $new;
    }

    public function withExpectation(ExpectationInterface $expectation): ExampleObj
    {
        $new = clone $this;
        $new->expectations[] = $expectation;
        return $new;
    }

    public function withImport(NameObj $name): ExampleObj
    {
        $new = clone $this;
        $new->imports[] = $name;
        return $new;
    }

    public function withIsContext(bool $flag): ExampleObj
    {
        $new = clone $this;
        $new->context = $flag;
        return $new;
    }

    public function withName(NameObj $name): ExampleObj
    {
        $new = clone $this;
        $new->name = $name;
        return $new;
    }
}
