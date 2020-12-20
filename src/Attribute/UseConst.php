<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class UseConst extends PrependCode
{
    private string $constname;
    private string $as = '';

    public function __construct(string $constname, string $as = '')
    {
        $code = "use const $constname";

        if ($as) {
            $code .= " as $as";
        }

        parent::__construct("$code;");

        $this->constname = $constname;
        $this->as = $as;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->constname, $this->as);
    }
}
