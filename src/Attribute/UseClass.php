<?php

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class UseClass extends PrependCode
{
    private string $classname;
    private string $as = '';

    public function __construct(string $classname, string $as = '')
    {
        $code = "use $classname";

        if ($as) {
            $code .= " as $as";
        }

        parent::__construct("$code;");

        $this->classname = $classname;
        $this->as = $as;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->classname, $this->as);
    }
}
