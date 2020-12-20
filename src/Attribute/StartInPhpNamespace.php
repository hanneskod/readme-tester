<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class StartInPhpNamespace extends PrependCode
{
    private string $namespace;

    public function __construct(string $namespace)
    {
        parent::__construct("namespace $namespace;");
        $this->namespace = $namespace;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->namespace);
    }
}
