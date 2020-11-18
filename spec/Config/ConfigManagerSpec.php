<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\ConfigManager;
use hanneskod\readmetester\Config\RepositoryInterface;
use PhpSpec\ObjectBehavior;

class ConfigManagerSpec extends ObjectBehavior
{
    function let(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $repo->getRepositoryName()->willReturn('');
        $this->beConstructedWith($repo);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConfigManager::class);
    }

    function it_collects_repository_names(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $repo->getRepositoryName()->willReturn('foo');
        $this->getLoadedRepositoryNames()->shouldIterateAs(['foo']);
    }

    function it_ignores_empty_names(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $repo->getRepositoryName()->willReturn('');
        $this->getLoadedRepositoryNames()->shouldIterateAs([]);
    }

    function it_can_read_config(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => 'bar']);
        $this->getConfig('foo')->shouldReturn('bar');
    }

    function it_can_read_nested_config(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => ['bar' => 'foobar']]);
        $this->getConfig('foo', 'bar')->shouldReturn('foobar');
    }

    function it_load_multiple_repos($repo, RepositoryInterface $repoB)
    {
        $repo->getConfigs()->willReturn(['foo' => 'A', 'bar' => 'A']);
        $repoB->getConfigs()->willReturn(['foo' => 'B']);
        $repoB->getRepositoryName()->willReturn('');
        $this->loadRepository($repoB);
        $this->getConfig('foo')->shouldReturn('B');
        $this->getConfig('bar')->shouldReturn('A');
    }

    function it_throws_on_missing_config(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $this->shouldThrow(\RuntimeException::class)->duringGetConfig('does-not-exist');
    }

    function it_throws_on_non_scalar_value(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['not-scalar' => []]);
        $this->shouldThrow(\RuntimeException::class)->duringGetConfig('not-scalar');
    }

    function it_casts_scalar_values_to_string(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['no-string' => 123]);
        $this->getConfig('no-string')->shouldReturn('123');
    }

    function it_can_read_config_list(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => ['bar', 'baz']]);
        $this->getConfigList('foo')->shouldIterateAs(['bar', 'baz']);
    }

    function it_throws_on_missing_config_list(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $this->shouldThrow(\RuntimeException::class)->duringGetConfigList('does-not-exist');
    }

    function it_throws_on_non_scalar_config_list_item(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => [[]]]);
        $this->shouldThrow(\RuntimeException::class)->duringGetConfigList('foo');
    }

    function it_casts_scalar_config_list_items_to_string(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => [1234]]);
        $this->getConfigList('foo')->shouldIterateAs(['1234']);
    }
}
