<?php

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Utils\Name;
use hanneskod\readmetester\Utils\CodeBlock;

interface ExampleInterface
{
    /**
     * @return iterable<object>
     */
    public function getAttributes(): iterable;

    /**
     * Get example code block
     */
    public function getCodeBlock(): CodeBlock;

    /**
     * @return iterable<ExpectationInterface>
     */
    public function getExpectations(): iterable;

    /**
     * @return iterable<Name>
     */
    public function getImports(): iterable;

    /**
     * Get example name
     */
    public function getName(): Name;

    /**
     * Check if example is active, eg. should be evaluated
     */
    public function isActive(): bool;

    /**
     * Check of thes example should work as a context for other examples
     */
    public function isContext(): bool;

    /**
     * Create a new example with active setting
     */
    public function withActive(bool $active): ExampleInterface;

    /**
     * Create a new example with code block
     */
    public function withCodeBlock(CodeBlock $code): ExampleInterface;

    /**
     * Create a new example with expectation
     */
    public function withExpectation(ExpectationInterface $expectation): ExampleInterface;

    /**
     * Create a new example with include
     */
    public function withImport(Name $name): ExampleInterface;

    /**
     * Create a new example that works as a context for other examples
     */
    public function withIsContext(bool $flag): ExampleInterface;

    /**
     * Create a new example with name
     */
    public function withName(Name $name): ExampleInterface;
}
