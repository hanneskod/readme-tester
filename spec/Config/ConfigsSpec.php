<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\Configs;
use PhpSpec\ObjectBehavior;

class ConfigsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Configs::class);
    }

    function it_expands_values_from_map()
    {
        $this->expand(['foo' => 'bar'], 'foo')->shouldReturn('bar');
    }

    function it_defaults_to_key()
    {
        $this->expand([], 'foo')->shouldReturn('foo');
    }

    function it_describes_map_keys()
    {
        $this->describe(['foo' => 'bar', 'baz' => 'barbaz'])->shouldReturn('foo, baz');
    }
}
