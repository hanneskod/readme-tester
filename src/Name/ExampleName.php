<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Name;

final class ExampleName implements NameInterface
{
    /** @var string */
    private $shortName;

    /** @var string */
    private $namespace;

    public function __construct(string $shortName, string $namespace)
    {
        $this->shortName = $shortName;
        $this->namespace = $namespace;
    }

    public function getName(): string
    {
        return $this->getNamespaceName() . self::NAME_DELIMITER . $this->getShortName();
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getNamespaceName(): string
    {
        return $this->namespace;
    }
}
