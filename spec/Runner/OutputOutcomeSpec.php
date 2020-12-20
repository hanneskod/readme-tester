<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\OutputOutcome;
use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Example\ExampleObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OutputOutcomeSpec extends ObjectBehavior
{
    function let(ExampleObj $example)
    {
        $this->beConstructedWith($example, 'foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OutputOutcome::class);
    }

    function it_is_an_outcome()
    {
        $this->shouldHaveType(OutcomeInterface::class);
    }

    function it_contains_example($example)
    {
        $this->getExample()->shouldReturn($example);
    }

    function it_knows_its_type()
    {
        $this->shouldNotBeError();
        $this->shouldBeOutput();
        $this->shouldNotBeSkipped();
        $this->shouldNotBeVoid();
    }

    function it_must_be_handled()
    {
        $this->mustBeHandled()->shouldReturn(true);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldReturn('foobar');
    }
}
