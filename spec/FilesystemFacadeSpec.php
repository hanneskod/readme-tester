<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\FilesystemFacade;
use hanneskod\readmetester\Event;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemFacadeSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemFacade::class);
    }

    function it_generates_input($dispatcher)
    {
        $dispatcher->dispatch(Argument::type(Event\FileIncluded::class))->shouldBeCalled();

        $this->getFilesystemInput(__DIR__, [''], ['php'], [])
            ->shouldIncludeFile('FilesystemFacadeSpec.php');
    }

    function it_filters_on_extesion()
    {
        $this->getFilesystemInput(__DIR__, [''], ['extension'], [])->shouldHaveCount(0);
    }

    function it_ignores_paths()
    {
        $this->getFilesystemInput(__DIR__, [''], ['php'], ['FilesystemFacadeSpec.php'])
            ->shouldNotIncludeFile('FilesystemFacadeSpec.php');
    }

    function it_includes_case_insensitive()
    {
        $this->getFilesystemInput(strtolower(__DIR__), [''], ['PHP'], [])
            ->shouldIncludeFile('FilesystemFacadeSpec.php');
    }

    function it_ignores_case_insensitive()
    {
        $this->getFilesystemInput(__DIR__, [''], ['php'], ['FilesystemFacadespec.php'])
            ->shouldNotIncludeFile('FilesystemFacadeSpec.php');
    }

    function getMatchers(): array
    {
        return [
            'includeFile' => function ($generator, $expectedFname) {
                foreach ($generator as $input) {
                    if ($input->getName() == $expectedFname) {
                        return true;
                    }
                }

                return false;
            },
            'notIncludeFile' => function ($generator, $expectedFname) {
                foreach ($generator as $input) {
                    if ($input->getName() == $expectedFname) {
                        return false;
                    }
                }

                return true;
            },
        ];
    }
}
