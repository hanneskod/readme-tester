<?php

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class StartInHtmlMode extends AbstractAttribute implements TransformationInterface
{
    private string $line;

    public function __construct()
    {
        $this->line = sprintf(
            "/*%s*/ ?>\n",
            $this->asAttribute()
        );
    }

    public function asAttribute(): string
    {
        return self::createAttribute();
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
