<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Exception;

use hanneskod\readmetester\Exception\InvalidPhpCodeException;
use hanneskod\readmetester\Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidPhpCodeExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('', '');
        $this->shouldHaveType(InvalidPhpCodeException::class);
    }

    function it_is_a_readmetester_exception()
    {
        $this->beConstructedWith('', '');
        $this->shouldHaveType(Exception::class);
    }

    function it_is_a_runtime_exception()
    {
        $this->beConstructedWith('', '');
        $this->shouldHaveType(\RuntimeException::class);
    }

    function it_contains_message()
    {
        $this->beConstructedWith('msg', '');
        $this->getMessage()->shouldReturn('msg');
    }

    function it_contains_php_code()
    {
        $this->beConstructedWith('', 'code');
        $this->getPhpCode()->shouldReturn('code');
    }
}
