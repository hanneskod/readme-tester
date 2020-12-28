<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class DeclareStrictTypes extends DeclareDirective
{
    public function __construct()
    {
        parent::__construct("strict_types=1");
    }

    public function asAttribute(): string
    {
        return self::createAttribute();
    }
}
