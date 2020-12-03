<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\FilesystemInputGenerator;
use hanneskod\readmetester\Event;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemInputGeneratorSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemInputGenerator::class);
    }

    function it_generates_input($dispatcher)
    {
        $dispatcher->dispatch(Argument::type(Event\FileIncluded::class))->shouldBeCalled();

        $this->generateFilesystemInput(__DIR__, [''], ['php'], [])
            ->shouldIncludeFile('FilesystemInputGeneratorSpec.php');
    }

    function it_filters_on_extesion()
    {
        $this->generateFilesystemInput(__DIR__, [''], ['extension'], [])->shouldHaveCount(0);
    }

    function it_ignores_paths()
    {
        $this->generateFilesystemInput(__DIR__, [''], ['php'], ['FilesystemInputGeneratorSpec.php'])
            ->shouldNotIncludeFile('FilesystemInputGeneratorSpec.php');
    }

    function it_includes_case_insensitive()
    {
        $this->generateFilesystemInput(strtolower(__DIR__), [''], ['PHP'], [])
            ->shouldIncludeFile('FilesystemInputGeneratorSpec.php');
    }

    function it_ignores_case_insensitive()
    {
        $this->generateFilesystemInput(__DIR__, [''], ['php'], ['filesysteminputgeneratorspec.php'])
            ->shouldNotIncludeFile('FilesystemInputGeneratorSpec.php');
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
