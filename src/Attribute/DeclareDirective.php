<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class DeclareDirective extends PrependCode
{
    private string $directive;

    public function __construct(string $directive)
    {
        parent::__construct("declare($directive);");
        $this->directive = $directive;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->directive);
    }
}
