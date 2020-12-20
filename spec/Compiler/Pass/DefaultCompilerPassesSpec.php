<?php
declare(strict_types=1);

namespace spec\hanneskod\readmetester\Compiler\Pass;

use hanneskod\readmetester\Compiler\Pass\DefaultCompilerPasses;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DefaultCompilerPassesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DefaultCompilerPasses::class);
    }

    function it_can_load_passes_at_construct(CompilerPassInterface $pass)
    {
        $this->beConstructedWith($pass);
        $this->getPasses()->shouldReturn([$pass]);
    }
}
