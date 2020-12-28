<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class Assert extends AppendCode
{
    private string $assertion;

    public function __construct(string $assertion)
    {
        parent::__construct("if (!$assertion) trigger_error('Assertion failed', E_USER_ERROR);");
        $this->assertion = $assertion;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->assertion);
    }
}
