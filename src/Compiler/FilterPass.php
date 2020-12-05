<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\Regexp;

/**
 * Filter examples based on names
 */
final class FilterPass implements CompilerPassInterface
{
    private ?Regexp $filter = null;

    public function setFilter(Regexp $filter): void
    {
        $this->filter = $filter;
    }

    public function process(ExampleStoreInterface $store): ExampleStoreInterface
    {
        if (!$this->filter) {
            return $store;
        }

        $examples = [];

        foreach ($store->getExamples() as $example) {
            if ($this->filter->matches($example->getName()->getFullName())) {
                $examples[] = $example;
            }
        }

        return new ArrayExampleStore($examples);
    }
}
