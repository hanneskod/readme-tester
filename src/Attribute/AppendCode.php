<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class AppendCode extends AbstractAttribute implements TransformationInterface
{
    private string $line;

    public function __construct(string $line)
    {
        $this->line = $line;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->line);
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withCodeBlock(
            $example->getCodeBlock()->append(
                new CodeBlock(
                    sprintf(
                        "%s\t// %s\n",
                        $this->line,
                        $this->asAttribute()
                    )
                )
            )
        );
    }
}
