<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\YamlFileLoader;
use hanneskod\readmetester\Config\ConfigManager;
use hanneskod\readmetester\Config\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YamlFileLoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(YamlFileLoader::class);
    }

    function it_loads_configs(ConfigManager $manager)
    {
        $this->beConstructedWith(__DIR__ . '/../../readme-tester.yaml.dist');

        $manager->loadRepository(Argument::type(RepositoryInterface::class))->shouldBeCalled();

        $this->loadYamlFile($manager);
    }

    function it_ignores_missing_config_file(ConfigManager $manager)
    {
        $this->beConstructedWith('does-not-exist');

        $manager->loadRepository(Argument::any())->shouldNotBeCalled();

        $this->loadYamlFile($manager);
    }
}
