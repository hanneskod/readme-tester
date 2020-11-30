<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class UseClass extends PrependCode
{
    public function __construct(string $classname, string $as = '')
    {
        $code = "use $classname";

        if ($as) {
            $code .= " as $as";
        }

        parent::__construct("$code;");
    }
}
