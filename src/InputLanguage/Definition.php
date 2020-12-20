<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\InputLanguage;

class Definition
{
    /**
     * @param array<string> $attributes
     */
    public function __construct(
        public array $attributes = [],
        public string $code = '',
    ) {}
}
