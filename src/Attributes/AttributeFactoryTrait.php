<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

trait AttributeFactoryTrait
{
    public static function createAttribute(string ...$args): string
    {
        $arglist = '';

        if ($args) {
            $arglist = sprintf(
                '("%s")',
                implode(
                    '"',
                    array_map(fn(string $arg) => addslashes(trim($arg)), $args)
                )
            );
        }

        return '\\' . get_called_class() . $arglist;
    }
}
