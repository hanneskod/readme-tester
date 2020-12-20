<?php

declare(strict_types=1);

namespace hanneskod\readmetester;

final class Version
{
    private const VERSION_FILE = __DIR__ . '/../VERSION';

    public static function getVersion(): string
    {
        if (is_readable(self::VERSION_FILE)) {
            return trim((string)file_get_contents(self::VERSION_FILE));
        }

        return 'dev-master';
    }
}
