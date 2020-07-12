<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\TransformationPass;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransformationPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TransformationPass::CLASS);
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType(CompilerPassInterface::CLASS);
    }

    function it_ignores_non_transformation_attributes(ExampleStoreInterface $store, ExampleObj $example)
    {
        $example->getAttributes()->willReturn([(object)array()]);
        $store->getExamples()->willReturn([$example]);
        $this->process($store)->shouldReturnExamples([$example]);
    }

    function it_transforms(
        ExampleStoreInterface $store,
        ExampleObj $originalExample,
        ExampleObj $transformedExample,
        TransformationInterface $transformation
    ) {
        $transformation->transform($originalExample)->willReturn($transformedExample);
        $originalExample->getAttributes()->willReturn([$transformation]);
        $store->getExamples()->willReturn([$originalExample]);
        $this->process($store)->shouldReturnExamples([$transformedExample]);
    }

    public function getMatchers(): array
    {
        return [
            'returnExamples' => function (ExampleStoreInterface $store, array $expected) {
                return iterator_to_array($store->getExamples()) == $expected;
            }
        ];
    }
}
