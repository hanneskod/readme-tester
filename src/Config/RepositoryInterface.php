<?php

namespace hanneskod\readmetester\Config;

interface RepositoryInterface
{
    /**
     * Get mixed configurations loaded in repository
     *
     * @return array<string, mixed>
     */
    public function getConfigs(): array;

    /**
     * Get name describing this repository
     */
    public function getRepositoryName(): string;
}
