<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\OutputExpectation;
use hanneskod\readmetester\Utils\Regexp;

#<<\PhpAttribute>>
class ExpectOutput implements TransformationInterface
{
    use AttributeFactoryTrait;

    private string $regexp;

    public function __construct(string $regexp)
    {
        $this->regexp = $regexp;
    }

    public function transform(ExampleInterface $example): ExampleInterface
    {
        return $example->withExpectation(
            new OutputExpectation(new Regexp($this->regexp))
        );
    }
}
