<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Compiler\Pass;

use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Event;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Remove examples that has been marked as inactive
 */
final class RemoveIgnoredExamplesPass implements CompilerPassInterface
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
    ) {}

    public function process(ExampleStoreInterface $store): ExampleStoreInterface
    {
        $examples = [];

        foreach ($store->getExamples() as $example) {
            if (!$example->isActive()) {
                $this->dispatcher->dispatch(new Event\ExampleIgnored($example));
                continue;
            }

            $examples[] = $example;
        }

        return new ArrayExampleStore($examples);
    }
}
