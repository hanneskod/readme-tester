<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Utils;

use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CodeBlockSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CodeBlock::CLASS);
    }

    function it_contains_code()
    {
        $this->getCode()->shouldReturn('foo');
    }

    function it_can_prepend_code()
    {
        $this->prepend(new CodeBlock('bar:'))->shouldBeLike(new CodeBlock('bar:foo'));
    }
}
