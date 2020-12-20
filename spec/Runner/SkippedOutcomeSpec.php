<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\SkippedOutcome;
use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Example\ExampleObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SkippedOutcomeSpec extends ObjectBehavior
{
    function let(ExampleObj $example)
    {
        $this->beConstructedWith($example, 'description');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SkippedOutcome::class);
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
        $this->shouldNotBeOutput();
        $this->shouldBeSkipped();
        $this->shouldNotBeVoid();
    }

    function it_must_not_be_handled()
    {
        $this->mustBeHandled()->shouldReturn(false);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldReturn('');
    }

    function it_contains_description()
    {
        $this->getDescription()->shouldReturn('description');
    }
}
