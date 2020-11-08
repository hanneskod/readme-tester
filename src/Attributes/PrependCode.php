<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

#[\Attribute]
class PrependCode implements TransformationInterface
{
    use AttributeFactoryTrait;

    private string $line;

    public function __construct(string $line)
    {
        $this->line = $line;
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withCodeBlock(
            $example->getCodeBlock()->prepend(
                new CodeBlock($this->line)
            )
        );
    }
}
