<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#<<\PhpAttribute>>
class StartInHtmlMode extends PrependCode
{
    public function __construct()
    {
        parent::__construct('?>');
    }
}
