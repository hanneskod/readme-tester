<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#[\Attribute]
class UseConst extends PrependCode
{
    public function __construct(string $constname, string $as = '')
    {
        $code = "use const $constname";

        if ($as) {
            $code .= " as $as";
        }

        parent::__construct("$code;");
    }
}
