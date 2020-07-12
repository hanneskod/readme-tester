<?php

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Utils\NameObj;

// TODO replace with ExampleStoreInterface
interface RegistryInterface
{
    /**
     * Register example
     */
    public function setExample(ExampleInterface $example): void;

    /**
     * Check if example is loaded
     */
    public function hasExample(NameObj $name): bool;

    /**
     * Get loaded example by name
     */
    public function getExample(NameObj $name): ExampleInterface;

    /**
     * Get all loaded examples
     *
     * @return ExampleInterface[]
     */
    public function getExamples(): array;
}
