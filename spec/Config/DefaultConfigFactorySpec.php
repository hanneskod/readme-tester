<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\DefaultConfigFactory;
use hanneskod\readmetester\Config\RepositoryInterface;
use PhpSpec\ObjectBehavior;

class DefaultConfigFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(DefaultConfigFactory::class);
    }

    function it_creates_configs()
    {
        $this->beConstructedWith('readme-tester.yaml.dist');
        $this->createRepository()->shouldHaveType(RepositoryInterface::class);
    }
}
