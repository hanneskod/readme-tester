<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

use Symfony\Component\Yaml\Yaml;

final class YamlFileLoader
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function loadYamlFile(ConfigManager $manager): void
    {
        if (is_readable($this->fileName)) {
            $manager->loadRepository(
                new ArrayRepository(Yaml::parseFile($this->fileName))
            );
        }
    }
}
