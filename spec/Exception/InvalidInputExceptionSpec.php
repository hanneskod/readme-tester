<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Exception;

use hanneskod\readmetester\Exception\InvalidInputException;
use hanneskod\readmetester\Exception;
use hanneskod\readmetester\Compiler\InputInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidInputExceptionSpec extends ObjectBehavior
{
    function let(InputInterface $input)
    {
        $this->beConstructedWith('', $input);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidInputException::class);
    }

    function it_is_a_readmetester_exception()
    {
        $this->shouldHaveType(Exception::class);
    }

    function it_is_a_runtime_exception()
    {
        $this->shouldHaveType(\RuntimeException::class);
    }

    function it_contains_message(InputInterface $input)
    {
        $this->beConstructedWith('msg', $input);
        $this->getMessage()->shouldReturn('msg');
    }

    function it_contains_input(InputInterface $input)
    {
        $this->beConstructedWith('', $input);
        $this->getInput()->shouldReturn($input);
    }

    function it_contains_verbose_message(InputInterface $input)
    {
        $this->beConstructedWith('', $input, 'verbose');
        $this->getVerboseMessage()->shouldReturn('verbose');
    }
}
