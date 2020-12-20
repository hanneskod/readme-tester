<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\YamlRepository;
use hanneskod\readmetester\Config\Configs;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YamlRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(YamlRepository::class);
    }

    function it_loads_configs()
    {
        $this->beConstructedWith(__DIR__ . '/../../etc/default_configuration.yaml');
        $this->getConfigs()->shouldHaveKeyWithValue(Configs::OUTPUT, 'default');
    }

    function it_throws_on_missing_config_file()
    {
        $this->beConstructedWith('does-not-exist');
        $this->shouldThrow(\RuntimeException::class)->duringGetConfigs();
    }

    function it_throws_on_non_file_path()
    {
        $this->beConstructedWith(__DIR__);
        $this->shouldThrow(\RuntimeException::class)->duringGetConfigs();
    }

    function it_uses_filename_as_name()
    {
        $this->beConstructedWith('filename');
        $this->getRepositoryName()->shouldReturn('filename');
    }
}
