<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Utils\Name;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\FailureException;
use Prophecy\Argument;

class ExampleSpec extends ObjectBehavior
{
    function let(Name $name, CodeBlock $codeBlock)
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

    function it_contains_attributes($name, $codeBlock)
    {
        $obj = new class() {
        };
        $this->beConstructedWith($name, $codeBlock, [$obj]);
        $this->getAttributes()->shouldIterateAs([$obj]);
    }

    function it_defaults_to_active()
    {
        $this->shouldBeActive();
    }

    function it_defaults_to_no_context()
    {
        $this->shouldNotBeContext();
    }

    function it_defaults_to_no_expectations()
    {
        $this->getExpectations()->shouldIterateAs([]);
    }

    function it_defaults_to_no_imports()
    {
        $this->getImports()->shouldIterateAs([]);
    }

    function it_can_create_with_active()
    {
        $this->withActive(false)->shouldCreateExampleThat(function ($example) {
            return false === $example->isActive();
        });
    }

    function it_can_create_with_context()
    {
        $this->withIsContext(true)->shouldCreateExampleThat(function ($example) {
            return true === $example->isContext();
        });
    }

    function it_can_create_with_code_block(CodeBlock $newCode)
    {
        $newCode = $newCode->getWrappedObject();
        $this->withCodeBlock($newCode)->shouldCreateExampleThat(function ($example) use ($newCode) {
            return $example->getCodeBlock() === $newCode;
        });
    }

    function it_can_create_with_expectation(ExpectationInterface $expectation)
    {
        $expectation = $expectation->getWrappedObject();
        $this->withExpectation($expectation)->shouldCreateExampleThat(function ($example) use ($expectation) {
            return $example->getExpectations() === [$expectation];
        });
    }

    function it_can_create_with_include(Name $include)
    {
        $include = $include->getWrappedObject();
        $this->withImport($include)->shouldCreateExampleThat(function ($example) use ($include) {
            return $example->getImports() === [$include];
        });
    }

    function it_can_create_with_name(Name $name)
    {
        $name = $name->getWrappedObject();
        $this->withName($name)->shouldCreateExampleThat(function ($example) use ($name) {
            return $example->getName() === $name;
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
