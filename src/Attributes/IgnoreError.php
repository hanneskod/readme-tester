<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#<<\PhpAttribute>>
class IgnoreError extends ExpectError
{
    public function __construct()
    {
        parent::__construct('//');
    }
}
