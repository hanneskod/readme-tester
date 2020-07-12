<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Utils\Name;

final class ExampleRegistry implements RegistryInterface
{
    /** @var ExampleInterface[] */
    private $examples = [];

    public function setExample(ExampleInterface $example): void
    {
        $this->examples[$example->getName()->getFullName()] = $example;
    }

    public function hasExample(Name $name): bool
    {
        return isset($this->examples[$name->getFullName()]);
    }

    public function getExample(Name $name): ExampleInterface
    {
        if (!isset($this->examples[$name->getFullName()])) {
            throw new \RuntimeException("Example '{$name->getShortName()}' does not exist");
        }

        return $this->examples[$name->getFullName()];
    }

    public function getExamples(): array
    {
        return array_values($this->examples);
    }
}
