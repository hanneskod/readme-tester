<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Compiler\Pass;

use hanneskod\readmetester\Compiler\Pass\RemoveIgnoredExamplesPass;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Event;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\NameObj;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RemoveIgnoredExamplesPassSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveIgnoredExamplesPass::class);
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType(CompilerPassInterface::class);
    }

    function it_removes_non_active_examples($dispatcher, ExampleObj $example, ExampleStoreInterface $store)
    {
        $example->isActive()->willReturn(false);
        $example->getName()->willReturn(new NameObj('', ''));

        $store->getExamples()->willReturn([$example]);

        $dispatcher->dispatch(Argument::type(Event\ExampleIgnored::class))->shouldBeCalled();

        $this->process($store)->shouldBeLike(new ArrayExampleStore([]));
    }

    function it_returns_active_examples($dispatcher, ExampleObj $example, ExampleStoreInterface $store)
    {
        $example->isActive()->willReturn(true);

        $store->getExamples()->willReturn([$example]);

        $dispatcher->dispatch(Argument::type(Event\ExampleIgnored::class))->shouldNotBeCalled();

        $this->process($store)->shouldBeLike(new ArrayExampleStore([$example->getWrappedObject()]));
    }
}
