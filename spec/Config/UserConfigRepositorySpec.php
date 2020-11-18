<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\UserConfigRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserConfigRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserConfigRepository::class);
    }

    function it_reads_configs()
    {
        $this->getConfigs()->shouldBeArray();
    }

    function it_reads_name()
    {
        $this->getRepositoryName()->shouldBeString();
    }
}
