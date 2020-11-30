<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Input;

use hanneskod\readmetester\Input\ReflectiveExampleStore;
use hanneskod\readmetester\Attribute\Ignore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Utils\NameObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReflectiveExampleStoreSpec extends ObjectBehavior
{
    function it_is_an_example_store()
    {
        $this->beAnInstanceOf(VoidStore::class);
        $this->shouldHaveType(ExampleStoreInterface::class);
    }

    function it_finds_example()
    {
        $this->beAnInstanceOf(SingleExampleStore::class);
        $this->getExamples()->shouldContainExample(
            new ExampleObj(
                new NameObj('', 'example1'),
                new CodeBlock('foobar'),
                [new Ignore]
            )
        );
    }

    function it_fins_only_examples_with_prefix()
    {
        $this->beAnInstanceOf(NoExampleStore::class);
        $this->getExamples()->shouldIterateAs([]);
    }

    function it_ignores_non_public_example_methods()
    {
        $this->beAnInstanceOf(NonPublicExampleStore::class);
        $this->getExamples()->shouldIterateAs([]);
    }

    function it_ignores_unknown_attributes()
    {
        $this->beAnInstanceOf(UnknownAttributeStore::class);
        $this->getExamples()->shouldContainExample(
            new ExampleObj(
                new NameObj('', 'example1'),
                new CodeBlock('foobar'),
                []
            )
        );
    }

    function it_reads_global_attributes_from_constructor()
    {
        $this->beAnInstanceOf(GlobalAttributesStore::class);
        $this->getExamples()->shouldContainExample(
            new ExampleObj(
                new NameObj('', 'example1'),
                new CodeBlock(''),
                [new Ignore]
            )
        );
    }

    function it_throws_on_required_example_parameter()
    {
        $this->beAnInstanceOf(ParameterRequiredStore::class);
        $this->getExamples()->shouldThrowLogicExceptionDuringIteration();
    }

    function it_throws_invalid_example_method_return_value()
    {
        $this->beAnInstanceOf(NoStringReturnedStore::class);
        $this->getExamples()->shouldThrowLogicExceptionDuringIteration();
    }

    public function getMatchers(): array
    {
        return [
            'containExample' => function (iterable $examples, ExampleObj $expected) {
                foreach ($examples as $example) {
                    if ($example->getName()->getFullName() == $expected->getName()->getFullName()
                        && $example->getCodeBlock()->getCode() == $expected->getCodeBlock()->getCode()
                        && $example->getAttributes() == $expected->getAttributes()
                    ) {
                        return true;
                    }
                }

                return false;
            },
            'throwLogicExceptionDuringIteration' => function (iterable $examples) {
                try {
                    foreach ($examples as $example) {
                    }
                } catch (\LogicException) {
                    return true;
                }

                return false;
            }
        ];
    }
}

// phpcs:disable

class VoidStore extends ReflectiveExampleStore
{
}

class SingleExampleStore extends ReflectiveExampleStore
{
    #[\hanneskod\readmetester\Attribute\Ignore]
    function example1(): string
    {
        return 'foobar';
    }
}

class NoExampleStore extends ReflectiveExampleStore
{
    function ignoredAsItDoesNotStartWithExamplePrefix(): string
    {
        return '';
    }
}

class NonPublicExampleStore extends ReflectiveExampleStore
{
    private function example1(): string
    {
        return '';
    }
}

class UnknownAttributeStore extends ReflectiveExampleStore
{
    #[\ignored\as\it\is\not\a\transformation]
    function example1(): string
    {
        return 'foobar';
    }
}

class GlobalAttributesStore extends ReflectiveExampleStore
{
    #[\hanneskod\readmetester\Attribute\Ignore]
    function __construct()
    {
    }

    function example1(): string
    {
        return '';
    }
}

class ParameterRequiredStore extends ReflectiveExampleStore
{
    function example1($requiredParameter): string
    {
        return '';
    }
}

class NoStringReturnedStore extends ReflectiveExampleStore
{
    function example1()
    {
        return ['this-is-an-array'];
    }
}
