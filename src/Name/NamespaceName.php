<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Name;

final class NamespaceName implements NameInterface
{
    /** @var string */
    private $namespace;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function getNamespaceName(): string
    {
        return $this->namespace;
    }

    public function getShortName(): string
    {
        throw new \RuntimeException('Unable to read short name from namespace');
    }

    public function getName(): string
    {
        $this->getShortName();
    }
}
