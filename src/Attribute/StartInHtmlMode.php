<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class StartInHtmlMode extends PrependCode
{
    public function __construct()
    {
        parent::__construct('?>');
    }
}
