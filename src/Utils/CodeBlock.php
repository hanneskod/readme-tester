<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Utils;

class CodeBlock
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function prepend(CodeBlock $codeBlock): CodeBlock
    {
        return new CodeBlock($codeBlock->getCode() . $this->getCode());
    }

    public function append(CodeBlock $codeBlock): CodeBlock
    {
        return $codeBlock->prepend($this);
    }
}
