<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Utils;

use hanneskod\readmetester\Exception\InvalidPhpCodeException;

final class Loader
{
    /** @var array<string, bool> */
    private static array $loaded = [];

    public static function loadRaw(string $code): mixed
    {
        return eval($code);
    }

    /** @throws InvalidPhpCodeException on php error in code */
    public static function load(string $code): mixed
    {
        try {
            return self::loadRaw($code);
        } catch (\Throwable $exception) {
            throw new InvalidPhpCodeException($exception->getMessage(), $code);
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
