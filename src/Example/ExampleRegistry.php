<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Utils\NameObj;

class ExampleRegistry
{
    /** @var array<ExampleObj> */
    private array $examples = [];

    public function setExample(ExampleObj $example): void
    {
        $this->examples[$example->getName()->getFullName()] = $example;
    }

    public function hasExample(NameObj $name): bool
    {
        return isset($this->examples[$name->getFullName()]);
    }

    public function getExample(NameObj $name): ExampleObj
    {
        if (!isset($this->examples[$name->getFullName()])) {
            throw new \RuntimeException("Example '{$name->getShortName()}' does not exist");
        }

        return $this->examples[$name->getFullName()];
    }

    /**
     * @return array<ExampleObj>
     */
    public function getExamples(): array
    {
        return array_values($this->examples);
    }
}
