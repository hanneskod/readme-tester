<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\FileInput;
use hanneskod\readmetester\Compiler\InputInterface;
use Symfony\Component\Finder\SplFileInfo;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileInputSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(new SplFileInfo('', '', ''));
        $this->shouldHaveType(FileInput::class);
    }

    function it_is_an_input()
    {
        $this->beConstructedWith(new SplFileInfo('', '', ''));
        $this->shouldHaveType(InputInterface::class);
    }

    function it_contains_a_default_namespace()
    {
        $this->beConstructedWith(new SplFileInfo('', '', 'foobar'));
        $this->getDefaultNamespace()->shouldReturn('foobar');
    }

    function it_contains_content()
    {
        $this->beConstructedWith(new SplFileInfo(__FILE__, '', ''));
        $this->getContents()->shouldReturn(file_get_contents(__FILE__));
    }

    function it_throws_on_non_readable_file()
    {
        $this->beConstructedWith(new SplFileInfo('this-filename-does-not-exist', '', ''));
        $this->shouldThrow(\RuntimeException::class)->duringGetContents();
    }
}
