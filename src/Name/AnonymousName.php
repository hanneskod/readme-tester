<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Name;

final class AnonymousName implements NameInterface
{
    /** @var string */
    private $namespace;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function getCompleteName(): string
    {
        return $this->getNamespaceName() . self::NAME_DELIMITER . $this->getShortName();
    }

    public function getShortName(): string
    {
        return 'UNNAMED';
    }

    public function getNamespaceName(): string
    {
        return $this->namespace;
    }

    public function equals(NameInterface $name): bool
    {
        return false;
    }
}
