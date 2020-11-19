<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#[\Attribute]
class UseFunction extends PrependCode
{
    public function __construct(string $funcname, string $as = '')
    {
        $code = "use function $funcname";

        if ($as) {
            $code .= " as $as";
        }

        parent::__construct("$code;");
    }
}
