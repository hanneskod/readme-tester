<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Console;

use hanneskod\readmetester\Console\FilesystemInputGenerator;
use hanneskod\readmetester\Event;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemInputGeneratorSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemInputGenerator::class);
    }

    function it_generates_input($dispatcher)
    {
        $dispatcher->dispatch(Argument::type(Event\FileIncluded::class))->shouldBeCalled();
        $this->generateFilesystemInput(__DIR__, [''], ['php'], [])->shouldHaveCount(1);
    }

    function it_filters_on_extesion()
    {
        $this->generateFilesystemInput(__DIR__, [''], ['extension'], [])->shouldHaveCount(0);
    }

    function it_ignores_on_extesion()
    {
        $this->generateFilesystemInput(__DIR__, [''], ['php'], ['FilesystemInputGeneratorSpec.php'])
            ->shouldHaveCount(0);
    }
}
