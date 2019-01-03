<?php

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Utils\CodeBlock;

interface ExampleInterface
{
    /**
     * Get example name
     */
    public function getName(): NameInterface;

    /**
     * Get example code block
     */
    public function getCodeBlock(): CodeBlock;

    /**
     * Get expectations associated with example
     *
     * @return ExpectationInterface[]
     */
    public function getExpectations(): array;

    /**
     * Check if example is active, eg. should be evaluated
     */
    public function isActive(): bool;

    /**
     * Create a new example with active setting
     */
    public function withActive(bool $active): ExampleInterface;
}
