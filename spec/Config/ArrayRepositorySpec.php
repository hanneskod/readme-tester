<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\ArrayRepository;
use hanneskod\readmetester\Config\RepositoryInterface;
use PhpSpec\ObjectBehavior;

class ArrayRepositorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayRepository::class);
    }

    function it_is_a_repository()
    {
        $this->shouldHaveType(RepositoryInterface::class);
    }

    function it_contains_configs()
    {
        $this->beConstructedWith(['foo' => 'bar']);
        $this->getConfigs()->shouldReturn(['foo' => 'bar']);
    }

    function it_has_an_empty_name()
    {
        $this->beConstructedWith([]);
        $this->getRepositoryName()->shouldReturn('');
    }
}
