<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#[\Attribute]
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
