<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class StartInPhpNamespace extends PrependCode
{
    public function __construct(string $namespace)
    {
        parent::__construct("namespace $namespace;");
    }
}
