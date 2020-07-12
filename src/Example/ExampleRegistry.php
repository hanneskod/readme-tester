<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Utils\NameObj;

final class ExampleRegistry implements RegistryInterface
{
    /** @var ExampleInterface[] */
    private $examples = [];

    public function setExample(ExampleInterface $example): void
    {
        $this->examples[$example->getName()->getFullName()] = $example;
    }

    public function hasExample(NameObj $name): bool
    {
        return isset($this->examples[$name->getFullName()]);
    }

    public function getExample(NameObj $name): ExampleInterface
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
