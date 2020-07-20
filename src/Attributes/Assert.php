<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

#<<\PhpAttribute>>
class Assert extends AppendCode
{
    public function __construct(string $assertion)
    {
        parent::__construct("if (!$assertion) trigger_error('Assertion failed', E_USER_ERROR);");
    }
}
