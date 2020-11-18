<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

use Symfony\Component\Yaml\Yaml;

final class DefaultConfigFactory
{
    private const DEFAULT_CONFIG_FILE = __DIR__ . '/../../readme-tester.yaml.dist';

    public function createRepository(): RepositoryInterface
    {
        if (!is_file(self::DEFAULT_CONFIG_FILE)) {
            throw new \LogicException('Unable to locate default configurations');
        }

        return new ArrayRepository(Yaml::parseFile(self::DEFAULT_CONFIG_FILE));
    }
}
