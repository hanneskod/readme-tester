<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Utils;

final class Loader
{
    /** @var array<string, bool> */
    private static array $loaded = [];

    public static function load(string $code): mixed
    {
        try {
            return eval($code);
        } catch (\Throwable $exception) {
            throw new \RuntimeException(
                sprintf(
                    "Unable to load '%s': %s",
                    $code,
                    $exception->getMessage()
                )
            );
        }
    }

    public static function loadOnce(string $code): void
    {
        $key = md5($code);

        if (!isset(self::$loaded[$key])) {
            self::$loaded[$key] = true;
            self::load($code);
        }
    }
}
