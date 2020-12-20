<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\Isolate;
use hanneskod\readmetester\Attribute\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IsolateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Isolate::class);
    }

    function it_is_an_attribute()
    {
        $this->shouldHaveType(AttributeInterface::class);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\Isolate]');
    }

    function it_can_get_as_attribute()
    {
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\Isolate]');
    }
}
