<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Name\NameInterface;

final class ExampleRegistry implements RegistryInterface
{
    /** @var ExampleInterface[] */
    private $examples = [];

    public function setExample(ExampleInterface $example): void
    {
        if ($example->getName()->isUnnamed()) {
            $this->examples[] = $example;
            return;
        }

        $this->examples[$example->getName()->getCompleteName()] = $example;
    }

    public function hasExample(NameInterface $name): bool
    {
        return !$name->isUnnamed() && isset($this->examples[$name->getCompleteName()]);
    }

    public function getExample(NameInterface $name): ExampleInterface
    {
        if (!isset($this->examples[$name->getCompleteName()])) {
            throw new \RuntimeException("Example '{$name->getShortName()}' does not exist");
        }

        return $this->examples[$name->getCompleteName()];
    }

    public function getExamples(): array
    {
        return array_values($this->examples);
    }
}
