<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class IgnoreError extends ExpectError
{
    public function __construct()
    {
        parent::__construct('//');
    }

    public function asAttribute(): string
    {
        return self::createAttribute();
    }
}
