<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\BootstrapFactory;
use hanneskod\readmetester\Event;
use hanneskod\readmetester\Utils\CodeBlock;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BootstrapFactorySpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BootstrapFactory::class);
    }

    function it_creates_bootstrap_from_file($dispatcher)
    {
        $dispatcher->dispatch(Argument::type(Event\BootstrapIncluded::class))->shouldBeCalled();

        $this->createFromFilenames([__FILE__])->shouldBeLike(
            new CodeBlock("require_once '" . __FILE__ . "';\n")
        );
    }
}
