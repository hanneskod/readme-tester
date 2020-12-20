<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Config;

final class ConfigManager
{
    /** @var array<string, mixed> */
    private array $configs = [];

    /** @var array<RepositoryInterface> */
    private array $repositories = [];

    /** @var array<Suite> */
    private array $suites = [];

    public function __construct(RepositoryInterface ...$repos)
    {
        foreach ($repos as $repo) {
            $this->loadRepository($repo);
        }
    }

    public function loadRepository(RepositoryInterface $repository): void
    {
        // Reset configs to trigger rebuild
        $this->configs = [];

        $this->repositories[] = $repository;
    }

    /** @return iterable<string> */
    public function getLoadedRepositoryNames(): iterable
    {
        foreach ($this->repositories as $repository) {
            if ($repository->getRepositoryName()) {
                yield $repository->getRepositoryName();
            }
        }
    }

    public function getBootstrap(): string
    {
        $bootstrap = $this->readConfig(Configs::BOOTSTRAP);

        if ($bootstrap && (!is_file($bootstrap) || !is_readable($bootstrap))) {
            throw new \RuntimeException("Unable to load bootstrap: $bootstrap");
        }

        return $bootstrap;
    }

    /** @return iterable<string> */
    public function getSubscribers(): iterable
    {
        yield from $this->readConfigList(Configs::SUBSCRIBERS);
        yield Configs::expand(Configs::OUTPUT_ID, $this->readConfig(Configs::OUTPUT));
    }

    public function getSuite(string $name): Suite
    {
        foreach ($this->getUnfilteredSuites() as $suite) {
            if ($suite->getSuiteName() == $name) {
                return $suite;
            }
        }

        throw new \RuntimeException("Unknown suite $name");
    }

    /** @return iterable<Suite> */
    public function getAllSuites(): iterable
    {
        foreach ($this->getUnfilteredSuites() as $suite) {
            if ($suite->isActive()) {
                yield $suite;
            }
        }
    }

    /** @return iterable<Suite> */
    private function getUnfilteredSuites(): iterable
    {
        $this->rebuildConfigsIfOutdated();
        yield from $this->suites;
    }

    private function readConfig(string $name): string
    {
        $this->rebuildConfigsIfOutdated();

        $value = $this->configs[$name] ?? '';

        if (!is_scalar($value)) {
            throw new \RuntimeException("Configuration for '$name invalid.");
        }

        return (string)$value;
    }

    /** @return array<string> */
    private function readConfigList(string $name): array
    {
        $this->rebuildConfigsIfOutdated();

        $list = $this->configs[$name] ?? [];

        if (!is_array($list)) {
            throw new \RuntimeException("Configuration list for '$name' invalid.");
        }

        $values = [];

        foreach ($list as $key => $value) {
            if (!is_scalar($value)) {
                throw new \RuntimeException(sprintf("Configuration for '%s[%s]' missing.", $name, $key));
            }

            $values[] = (string)$value;
        }

        return $values;
    }

    private function rebuildConfigsIfOutdated(): void
    {
        // Only rebuild if neccesary
        if ($this->configs) {
            return;
        }

        // Base configs
        $configs = [
            Configs::SUITES => [],
            Configs::CLI => [],
        ];

        $defaults = [];

        // Merge with repositories
        foreach ($this->repositories as $repository) {
            $configs = array_merge($configs, $repository->getConfigs());

            // Merge defaults separatly to account for multiple default definitions
            $defaults = array_merge(
                $defaults,
                (array)($repository->getConfigs()[Configs::DEFAULTS] ?? [])
            );
        }

        // Create default suite if none exists
        if (empty($configs[Configs::SUITES])) {
            $configs[Configs::SUITES][Configs::DEFAULT_SUITE_NAME] = [];
        }

        // Build suite objects
        $this->suites = [];

        foreach ($configs[Configs::SUITES] as $name => $suite) {
            // Merge suite with default configs
            $suite = array_merge($defaults, (array)$suite);

            // Merge suite with cli configs
            $suite = array_merge($suite, (array)$configs[Configs::CLI]);

            // Build suite
            $this->suites[] = new Suite(
                name: (string)$name,
                active: (bool)($suite[Configs::ACTIVE] ?? true),
                inputLanguage: (string)($suite[Configs::INPUT_LANGUAGE] ?? ''),
                runner: (string)($suite[Configs::RUNNER] ?? ''),
                includePaths: (array)($suite[Configs::INCLUDE_PATHS] ?? []),
                excludePaths: (array)($suite[Configs::EXCLUDE_PATHS] ?? []),
                fileExtensions: (array)($suite[Configs::FILE_EXTENSIONS] ?? []),
                stopOnFailure: (bool)($suite[Configs::STOP_ON_FAILURE] ?? false),
                globalAttributes: (array)($suite[Configs::GLOBAL_ATTRIBUTES] ?? []),
                filter: (string)($suite[Configs::FILTER] ?? ''),
                readFromStdin: (bool)($suite[Configs::STDIN] ?? false),
            );
        }

        // Store configs
        $this->configs = array_merge($configs, $configs[Configs::CLI]);
    }
}
