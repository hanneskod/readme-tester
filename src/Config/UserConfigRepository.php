<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Config;

use Symfony\Component\Yaml\Yaml;

final class UserConfigRepository implements RepositoryInterface
{
    public const CONFIG_FILENAME = 'readme-tester.yaml';
    public const DIST_CONFIG_FILENAME = 'readme-tester.yaml.dist';

    /** @var array<string, mixed> */
    private array $configs = [];

    private string $name = '';

    public function __construct()
    {
        foreach ([self::CONFIG_FILENAME, self::DIST_CONFIG_FILENAME] as $filename) {
            if (is_file($filename) && is_readable($filename)) {
                $this->configs = (array)Yaml::parseFile($filename);
                $this->name = $filename;
                break;
            }
        }
    }

    public function getConfigs(): array
    {
        return $this->configs;
    }

    public function getRepositoryName(): string
    {
        return $this->name;
    }
}
