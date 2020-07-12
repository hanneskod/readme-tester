<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Example\ExampleObj;

#<<\PhpAttribute>>
class Example extends Name
{
    public function __construct(string $name = '')
    {
        parent::__construct($name);
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        if ($this->name) {
            return parent::transform($example);
        }

        return $example;
    }
}
