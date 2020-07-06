<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Example\ExampleInterface;

#<<\PhpAttribute>>
class Example extends Name
{
    public function __construct(string $name = '')
    {
        parent::__construct($name);
    }

    public function transform(ExampleInterface $example): ExampleInterface
    {
        if ($this->name) {
            return parent::transform($example);
        }

        return $example;
    }
}
