<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class UseFunction extends PrependCode
{
    private string $funcname;
    private string $as = '';

    public function __construct(string $funcname, string $as = '')
    {
        $code = "use function $funcname";

        if ($as) {
            $code .= " as $as";
        }

        parent::__construct("$code;");

        $this->funcname = $funcname;
        $this->as = $as;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->funcname, $this->as);
    }
}
