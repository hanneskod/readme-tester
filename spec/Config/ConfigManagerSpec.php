<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\ConfigManager;
use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Config\RepositoryInterface;
use hanneskod\readmetester\Config\Suite;
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

    function it_collects_repository_names($repo)
    {
        $repo->getConfigs()->willReturn([]);
        $repo->getRepositoryName()->willReturn('foo');
        $this->getLoadedRepositoryNames()->shouldIterateAs(['foo']);
    }

    function it_ignores_empty_names($repo)
    {
        $repo->getConfigs()->willReturn([]);
        $repo->getRepositoryName()->willReturn('');
        $this->getLoadedRepositoryNames()->shouldIterateAs([]);
    }

    function it_finds_bootstrap($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::BOOTSTRAP => __FILE__,
        ]);

        $this->getBootstrap()->shouldReturn(__FILE__);
    }

    function it_reas_bootstrap_from_last_loaded_repo($repo, RepositoryInterface $repoB)
    {
        $repo->getConfigs()->willReturn([
            Configs::BOOTSTRAP => 'does-not-exist',
        ]);

        $repoB->getConfigs()->willReturn([
            Configs::BOOTSTRAP => __FILE__,
        ]);

        $this->loadRepository($repoB);

        $this->getBootstrap()->shouldReturn(__FILE__);
    }

    function it_throws_on_unknown_bootstrap($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::BOOTSTRAP => 'this-file-does-not-exist',
        ]);

        $this->shouldThrow(\RuntimeException::class)->duringGetBootstrap();
    }

    function it_throws_on_invalid_bootstrap($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::BOOTSTRAP => ['this-is-not-scalar'],
        ]);

        $this->shouldThrow(\RuntimeException::class)->duringGetBootstrap();
    }

    function it_does_not_throw_on_empty_bootstrap($repo)
    {
        $repo->getConfigs()->willReturn([]);

        $this->getBootstrap()->shouldReturn('');
    }

    function it_reas_bootstrap_after_rebuild($repo, RepositoryInterface $repoB)
    {
        $repo->getConfigs()->willReturn([]);

        $this->getBootstrap()->shouldReturn('');

        $repoB->getConfigs()->willReturn([
            Configs::BOOTSTRAP => __FILE__,
        ]);

        $this->loadRepository($repoB);

        $this->getBootstrap()->shouldReturn(__FILE__);
    }

    function it_reads_cli_bootstrap_over_standard($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::BOOTSTRAP => 'this-file-does-not-exist',
            Configs::CLI => [
                Configs::BOOTSTRAP => __FILE__,
            ]
        ]);

        $this->getBootstrap()->shouldReturn(__FILE__);
    }

    function it_finds_subscribers($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::SUBSCRIBERS => ['foo'],
            Configs::OUTPUT => 'bar'
        ]);

        $this->getSubscribers()->shouldYieldValues(['foo', 'bar']);
    }

    function it_expands_output_name($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::SUBSCRIBERS => [],
            Configs::OUTPUT => 'debug'
        ]);

        $this->getSubscribers()->shouldYieldValues([Configs::OUTPUT_ID[Configs::OUTPUT_ID_DEBUG]]);
    }

    function it_reads_cli_subscribers_over_standard($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::CLI => [
                Configs::OUTPUT => 'bar',
            ]
        ]);

        $this->getSubscribers()->shouldYieldValues(['bar']);
    }

    function it_throws_on_unknown_suite($repo)
    {
        $this->shouldThrow(\RuntimeException::class)->duringGetSuite('does-not-exist');
    }

    function it_returns_named_suite($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::SUITES => [
                'foosuite' => []
            ]
        ]);

        $this->getSuite('foosuite')->shouldBeLike(
            new Suite(name: 'foosuite')
        );
    }

    function it_returns_named_suite_even_if_not_active($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::SUITES => [
                'not-active' => [
                    Configs::ACTIVE => false,
                ]
            ]
        ]);

        $this->getSuite('not-active')->shouldBeLike(
            new Suite(
                name: 'not-active',
                active: false
            )
        );
    }

    function it_adds_defaults_to_suite($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::DEFAULTS => [
                    Configs::INCLUDE_PATHS => ['default'],
            ],
            Configs::SUITES => [
                'foosuite' => [],
            ],
        ]);

        $this->getSuite('foosuite')->shouldBeLike(
            new Suite(
                name: 'foosuite',
                includePaths: ['default'],
            )
        );
    }

    function it_overwrites_defaults_with_suite_data($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::DEFAULTS => [
                    Configs::FILE_EXTENSIONS => ['default'],
            ],
            Configs::SUITES => [
                'foosuite' => [
                    Configs::FILE_EXTENSIONS => ['suite'],
                ],
            ],
        ]);

        $this->getSuite('foosuite')->shouldBeLike(
            new Suite(
                name: 'foosuite',
                fileExtensions: ['suite'],
            )
        );
    }

    function it_overwrites_suite_data_with_cli_data($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::DEFAULTS => [
                    Configs::EXCLUDE_PATHS => ['default'],
            ],
            Configs::SUITES => [
                'foosuite' => [
                    Configs::EXCLUDE_PATHS => ['suite'],
                ],
            ],
            Configs::CLI => [
                    Configs::EXCLUDE_PATHS => ['cli'],
            ],
        ]);

        $this->getSuite('foosuite')->shouldBeLike(
            new Suite(
                name: 'foosuite',
                excludePaths: ['cli'],
            )
        );
    }

    function it_applies_defaults_and_cli_data_to_all_suites($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::CLI => [
                    Configs::INCLUDE_PATHS => ['cli_include'],
            ],
            Configs::SUITES => [
                'foosuite' => [
                    Configs::FILE_EXTENSIONS => ['foosuite_extension'],
                ],
                'barsuite' => [
                    Configs::FILE_EXTENSIONS => ['barsuite_extension'],
                ],
            ],
            Configs::DEFAULTS => [
                    Configs::EXCLUDE_PATHS => ['default_exclude'],
            ],
        ]);

        $this->getAllSuites()->shouldIterateLike([
            new Suite(
                name: 'foosuite',
                excludePaths: ['default_exclude'],
                includePaths: ['cli_include'],
                fileExtensions: ['foosuite_extension'],
            ),
            new Suite(
                name: 'barsuite',
                excludePaths: ['default_exclude'],
                includePaths: ['cli_include'],
                fileExtensions: ['barsuite_extension'],
            ),
        ]);
    }

    function it_ignores_non_active_suites_when_accessing_all_suites($repo)
    {
        $repo->getConfigs()->willReturn([
            Configs::SUITES => [
                'active' => [
                    Configs::ACTIVE => true,
                ],
                'not-active' => [
                    Configs::ACTIVE => false,
                ],
            ],
        ]);

        $this->getAllSuites()->shouldYieldValues([
            new Suite(name: 'active')
        ]);
    }

    function it_creates_default_suite_if_non_is_definied($repo)
    {
        $repo->getConfigs()->willReturn([]);

        $this->getAllSuites()->shouldIterateLike([
            new Suite(name: 'default')
        ]);
    }

    function it_loads_complex_data_from_multiple_repos(
        RepositoryInterface $defaults,
        RepositoryInterface $cli,
        RepositoryInterface $user,
    ) {
        $defaults->getConfigs()->willReturn([
            Configs::DEFAULTS => [
                    Configs::EXCLUDE_PATHS => ['default_exclude'],
                    Configs::FILE_EXTENSIONS => ['default_extension'],
            ],
        ]);

        $cli->getConfigs()->willReturn([
            Configs::CLI => [
                    Configs::INCLUDE_PATHS => ['cli_include'],
            ],
        ]);

        $user->getConfigs()->willReturn([
            Configs::SUITES => [
                'foosuite' => [
                    // Should overwrite default_extension
                    Configs::FILE_EXTENSIONS => ['foosuite_extension'],
                ],
                'barsuite' => [
                    // Should be overwritten by cli_include
                    Configs::INCLUDE_PATHS => ['bars_include'],
                ],
            ],
        ]);

        $this->loadRepository($cli);
        $this->loadRepository($user);
        $this->loadRepository($defaults);

        $this->getAllSuites()->shouldIterateLike([
            new Suite(
                name: 'foosuite',
                excludePaths: ['default_exclude'],
                includePaths: ['cli_include'],
                fileExtensions: ['foosuite_extension'],
            ),
            new Suite(
                name: 'barsuite',
                excludePaths: ['default_exclude'],
                includePaths: ['cli_include'],
                fileExtensions: ['default_extension'],
            ),
        ]);
    }

    function it_readbuilds_suites_after_repo_load($repo, RepositoryInterface $foosuite)
    {
        $repo->getConfigs()->willReturn([]);

        $foosuite->getConfigs()->willReturn([
            Configs::SUITES => [
                'foosuite' => []
            ],
        ]);

        $this->getAllSuites()->shouldIterateLike([
            new Suite(name: 'default')
        ]);

        $this->loadRepository($foosuite);

        $this->getAllSuites()->shouldIterateLike([
            new Suite(name: 'foosuite')
        ]);
    }

    function it_combines_multiple_defaults_definitions(
        RepositoryInterface $defaultsA,
        RepositoryInterface $defaultsB,
        RepositoryInterface $foosuite,
    ) {
        $defaultsA->getConfigs()->willReturn([
            Configs::DEFAULTS => [
                // Should be overwritten by defaultsB
                Configs::EXCLUDE_PATHS => ['defaultsA_exclude'],
                // Should be overwritten by foosuite_defaults
                Configs::INCLUDE_PATHS => ['defaultsA_include'],
                // Should be overwritten by foosuite
                Configs::INPUT_LANGUAGE => 'defaultsA_input_language',
                // SHould stand
                Configs::RUNNER => 'defaultsA_runner',
            ],
        ]);

        $defaultsB->getConfigs()->willReturn([
            Configs::DEFAULTS => [
                Configs::EXCLUDE_PATHS => ['defaultsB_exclude'],
            ],
        ]);

        $foosuite->getConfigs()->willReturn([
            Configs::DEFAULTS => [
                Configs::INCLUDE_PATHS => ['foosuite_defaults_include'],
            ],
            Configs::SUITES => [
                'foosuite' => [
                    Configs::INPUT_LANGUAGE => 'foosuite_input_language',
                ]
            ],
        ]);

        $this->loadRepository($defaultsA);
        $this->loadRepository($defaultsB);
        $this->loadRepository($foosuite);

        $this->getAllSuites()->shouldIterateLike([
            new Suite(
                name: 'foosuite',
                excludePaths: ['defaultsB_exclude'],
                includePaths: ['foosuite_defaults_include'],
                inputLanguage: 'foosuite_input_language',
                runner: 'defaultsA_runner',
            )
        ]);
    }

    function getMatchers(): array
    {
        return [
            'yieldValues' => function (\Generator $generator, array $expected) {
                $generatorValues = array_values(iterator_to_array($generator, false));
                $expectedValues = array_values($expected);

                foreach ($generatorValues as $key => $value) {
                    if (!isset($expectedValues[$key]) || $value != $expectedValues[$key]) {
                        return false;
                    }
                }

                return true;
            }
        ];
    }
}
