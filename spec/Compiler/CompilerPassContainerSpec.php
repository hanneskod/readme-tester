<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\CompilerPassContainer;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompilerPassContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CompilerPassContainer::class);
    }

    function it_can_load_passes_at_construct(CompilerPassInterface $pass)
    {
        $this->beConstructedWith($pass);
        $this->getCompilerPasses()->shouldReturn([$pass]);
    }

    function it_can_load_passes_later(CompilerPassInterface $pass)
    {
        $this->getCompilerPasses()->shouldReturn([]);
        $this->addCompilerPass($pass);
        $this->getCompilerPasses()->shouldReturn([$pass]);
    }
}
