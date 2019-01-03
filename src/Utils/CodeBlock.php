<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Utils;

class CodeBlock
{
    /** @var string */
    private $code;

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
}
