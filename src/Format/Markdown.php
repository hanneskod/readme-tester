<?php

namespace hanneskod\readmetester\Format;

/**
 * Identify markdown formatted php code blocks
 */
class Markdown implements FormatInterface
{
    public function isExampleStart($line)
    {
        return !!preg_match('/^```php\s*$/i', $line);
    }

    public function isExampleEnd($line)
    {
        return !!preg_match('/^```\s*$/', $line);
    }
}
