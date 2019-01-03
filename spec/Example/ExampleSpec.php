<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\FailureException;
use Prophecy\Argument;

class ExampleSpec extends ObjectBehavior
{
    function let(NameInterface $name, CodeBlock $codeBlock)
    {
        $this->beConstructedWith($name, $codeBlock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Example::CLASS);
    }

    function it_is_an_example()
    {
        $this->shouldHaveType(ExampleInterface::CLASS);
    }

    function it_contains_name($name)
    {
        $this->getName()->shouldReturn($name);
    }

    function it_contains_code($codeBlock)
    {
        $this->getCodeBlock()->shouldReturn($codeBlock);
    }

    function it_defaults_to_active()
    {
        $this->shouldBeActive();
    }

    function it_can_create_with_active()
    {
        $this->withActive(false)->shouldCreateExampleThat(function ($example) {
            return $example->isActive() == false;
        });
    }

    public function getMatchers(): array
    {
        return [
            'createExampleThat' => function (ExampleInterface $example, callable $operation) {
                return !!$operation($example);
            }
        ];
    }
}
