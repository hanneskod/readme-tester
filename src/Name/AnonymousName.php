<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Name;

final class AnonymousName extends NamespacedName
{
    public function __construct(string $namespace = '')
    {
        parent::__construct($namespace, 'UNNAMED');
    }

    public function equals(NameInterface $name): bool
    {
        return false;
    }

    public function isUnnamed(): bool
    {
        return true;
    }
}
