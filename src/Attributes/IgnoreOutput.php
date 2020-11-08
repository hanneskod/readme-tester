<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#[\Attribute]
class IgnoreOutput extends ExpectOutput
{
    public function __construct()
    {
        parent::__construct('//');
    }
}
