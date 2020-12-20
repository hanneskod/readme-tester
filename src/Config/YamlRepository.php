<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

final class YamlRepository implements RepositoryInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getConfigs(): array
    {
        if (!is_file($this->filename) || !is_readable($this->filename)) {
            throw new \RuntimeException("Unable to read configs from {$this->filename}");
        }

        try {
            return Yaml::parseFile($this->filename);
        } catch (ParseException $exception) {
            throw new \RuntimeException("Unable to parse '{$this->filename}': {$exception->getMessage()}");
        }
    }

    public function getRepositoryName(): string
    {
        return $this->filename;
    }
}
