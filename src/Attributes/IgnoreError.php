<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#[\Attribute]
class IgnoreError extends ExpectError
{
    public function __construct()
    {
        parent::__construct('//');
    }
}
