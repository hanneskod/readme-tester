<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Event;

use hanneskod\readmetester\Event\ExitStatusListener;
use hanneskod\readmetester\Event;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExitStatusListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExitStatusListener::class);
    }

    function it_defaults_to_zero_status_code()
    {
        $this->getStatusCode()->shouldReturn(0);
    }

    function it_collects_failing_status(Event\TestFailed $event)
    {
        $this->__invoke($event->getWrappedObject());
        $this->getStatusCode()->shouldReturn(1);
    }
}
