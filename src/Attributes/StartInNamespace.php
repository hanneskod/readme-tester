<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#[\Attribute]
class StartInNamespace extends PrependCode
{
    public function __construct(string $namespace)
    {
        parent::__construct("namespace $namespace;");
    }
}
