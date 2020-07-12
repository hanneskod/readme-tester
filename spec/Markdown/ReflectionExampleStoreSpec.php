<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Markdown\ReflectionExampleStore;
use hanneskod\readmetester\Attributes\Ignore;
use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Utils\Name;
use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\FailureException;
use Prophecy\Argument;

class ReflectionExampleStoreSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(ConcreteReflectionExampleStore::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ReflectionExampleStore::CLASS);
    }

    function it_is_an_example_store()
    {
        $this->shouldHaveType(ExampleStoreInterface::CLASS);
    }

    function it_finds_example()
    {
        $this->getExamples()->shouldContainExample(
            new Example(
                new Name('', 'example1'),
                new CodeBlock('foobar'),
                [new Ignore]
            )
        );
    }

    public function getMatchers(): array
    {
        return [
            'containExample' => function (iterable $examples, Example $expected) {
                foreach ($examples as $example) {
                    if ($example->getName()->getFullName() == $expected->getName()->getFullName()
                        && $example->getCodeBlock()->getCode() == $expected->getCodeBlock()->getCode()
                        && $example->getAttributes() == $expected->getAttributes()
                    ) {
                        return true;
                    }
                }

                return false;
            }
        ];
    }
}

// phpcs:disable
class ConcreteReflectionExampleStore extends ReflectionExampleStore
{
    /**
     * new hanneskod\readmetester\Attributes\Ignore
     */
    function example1()
    {
        return 'foobar';
    }
}
