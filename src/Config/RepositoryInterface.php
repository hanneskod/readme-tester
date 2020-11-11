<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

interface RepositoryInterface
{
    /**
     * Get mixed configurations loaded in repository
     *
     * @return array<string, mixed>
     */
    public function getConfigs(): array;
}
