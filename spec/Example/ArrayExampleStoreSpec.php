<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayExampleStoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayExampleStore::class);
    }

    function it_is_an_example_store()
    {
        $this->shouldHaveType(ExampleStoreInterface::class);
    }

    function it_contains_examples(ExampleObj $example)
    {
        $this->beConstructedWith([$example]);
        $this->getExamples()->shouldIterateAs([$example]);
    }
}
