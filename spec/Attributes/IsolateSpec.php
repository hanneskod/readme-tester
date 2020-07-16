<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\Isolate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IsolateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Isolate::class);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('\hanneskod\readmetester\Attributes\Isolate');
    }
}
