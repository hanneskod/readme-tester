<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CombinedExampleStoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CombinedExampleStore::class);
    }

    function it_is_an_example_store()
    {
        $this->shouldHaveType(ExampleStoreInterface::class);
    }

    function it_defaults_to_no_examples()
    {
        $this->getExamples()->shouldIterateAs([]);
    }

    function it_can_add_example_store(ExampleStoreInterface $store, ExampleObj $example)
    {
        $store->getExamples()->willReturn([$example]);
        $this->addExampleStore($store);
        $this->getExamples()->shouldIterateAs([$example]);
    }
}
