<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input;

class Definition
{
    /** @var array<string> */
    public array $attributes;
    public string $code;

    /**
     * @param array<string> $attributes
     */
    public function __construct(array $attributes, string $code)
    {
        $this->attributes = $attributes;
        $this->code = $code;
    }
}
