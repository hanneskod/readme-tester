<?php

// phpcs:disable Squiz.WhiteSpace.ScopeClosingBrace

declare(strict_types=1);

namespace hanneskod\readmetester\Compiler\Pass;

use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\Regexp;

/**
 * Filter examples based on names
 */
final class FilterPass implements CompilerPassInterface
{
    public function __construct(
        private Regexp $filter,
    ) {}

    public function process(ExampleStoreInterface $store): ExampleStoreInterface
    {
        $examples = [];

        foreach ($store->getExamples() as $example) {
            if ($this->filter->matches($example->getName()->getFullName())) {
                $examples[] = $example;
            }
        }

        return new ArrayExampleStore($examples);
    }
}
