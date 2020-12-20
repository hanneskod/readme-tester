<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

abstract class AbstractAttribute implements AttributeInterface
{
    public function asAttribute(): string
    {
        return self::createAttribute();
    }

    public static function createAttribute(string ...$args): string
    {
        $arglist = '';

        if ($args) {
            $arglist = sprintf(
                '("%s")',
                implode(
                    '", "',
                    array_map(
                        fn(string $arg) => addslashes(trim($arg)),
                        array_filter($args)
                    )
                )
            );
        }

        return '#[\\' . get_called_class() . $arglist . ']';
    }
}
