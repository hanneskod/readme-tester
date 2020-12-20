<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Output;

class VoidSyntaxHighlighter extends SyntaxHighlighter
{
    public function __construct()
    {
    }

    public function highlight(string $code): string
    {
        return $code;
    }
}
