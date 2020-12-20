<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Example;

final class CombinedExampleStore implements ExampleStoreInterface
{
    /** @var array<ExampleStoreInterface> */
    private array $stores = [];

    public function addExampleStore(ExampleStoreInterface $store): void
    {
        $this->stores[] = $store;
    }

    public function getExamples(): iterable
    {
        foreach ($this->stores as $store) {
            yield from $store->getExamples();
        }
    }
}
