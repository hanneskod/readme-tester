<?php

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Utils\Name;

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
    public function hasExample(Name $name): bool;

    /**
     * Get loaded example by name
     */
    public function getExample(Name $name): ExampleInterface;

    /**
     * Get all loaded examples
     *
     * @return ExampleInterface[]
     */
    public function getExamples(): array;
}
