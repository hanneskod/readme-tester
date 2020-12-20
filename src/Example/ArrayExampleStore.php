<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Example;

final class ArrayExampleStore implements ExampleStoreInterface
{
    /** @var array<ExampleObj> */
    private array $examples;

    /**
     * @param array<ExampleObj> $examples
     */
    public function __construct(array $examples = [])
    {
        $this->examples = $examples;
    }

    public function getExamples(): iterable
    {
        yield from $this->examples;
    }
}
