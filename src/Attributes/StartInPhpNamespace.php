<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#[\Attribute]
class StartInPhpNamespace extends PrependCode
{
    public function __construct(string $namespace)
    {
        parent::__construct("namespace $namespace;");
    }
}
