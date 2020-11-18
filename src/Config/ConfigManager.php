<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ConfigManager
{
    /** @var array<string, mixed> */
    private array $configs = [];

    /** @var array<string> */
    private array $names = [];

    private PropertyAccessor $propertyAccessor;

    public function __construct(RepositoryInterface ...$repos)
    {
        foreach ($repos as $repo) {
            $this->loadRepository($repo);
        }

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function loadRepository(RepositoryInterface $repository): void
    {
        $this->configs = array_merge($this->configs, $repository->getConfigs());

        if ($repository->getRepositoryName()) {
            $this->names[] = $repository->getRepositoryName();
        }
    }

    /** @return array<string> */
    public function getLoadedRepositoryNames(): array
    {
        return $this->names;
    }

    public function getConfig(string ...$nameParts): string
    {
        $namePath = '[' . implode('][', $nameParts) . ']';

        $value = $this->propertyAccessor->getValue($this->configs, $namePath);

        if (!is_scalar($value)) {
            throw new \RuntimeException("Configuration for '$namePath' missing.");
        }

        return (string)$value;
    }

    /** @return array<string> */
    public function getConfigList(string ...$nameParts): array
    {
        $namePath = '[' . implode('][', $nameParts) . ']';

        $list = $this->propertyAccessor->getValue($this->configs, $namePath);

        if (!is_array($list)) {
            throw new \RuntimeException("Configuration list for '$namePath' invalid.");
        }

        $values = [];

        foreach ($list as $key => $value) {
            if (!is_scalar($value)) {
                throw new \RuntimeException(sprintf("Configuration for '%s[%s]' missing.", $namePath, $key));
            }

            $values[] = (string)$value;
        }

        return $values;
    }
}
