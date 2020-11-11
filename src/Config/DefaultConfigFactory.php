<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

use Symfony\Component\Yaml\Yaml;

final class DefaultConfigFactory
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function createRepository(): RepositoryInterface
    {
        return new ArrayRepository(
            Yaml::parseFile(
                __DIR__ . '/../../' . $this->fileName
            )
        );
    }
}
