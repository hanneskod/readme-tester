<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

final class ArrayRepository implements RepositoryInterface
{
    /**
     * @var array<string, mixed>
     */
    private $configs;

    /**
     * @param array<string, mixed> $configs
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function getConfigs(): array
    {
        return $this->configs;
    }

    public function getRepositoryName(): string
    {
        return '';
    }
}
