<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Utils;

final class Loader
{
    /** @var array<string, bool> */
    private static array $loaded = [];

    /**
     * @return mixed
     */
    public static function load(string $code)
    {
        // TODO loader could choose a different strategy if eval() is not avaliable
        return eval($code);
    }

    /**
     * @return mixed
     */
    public static function loadOnce(string $code)
    {
        $key = md5($code);

        if (!isset(self::$loaded[$key])) {
            self::$loaded[$key] = true;
            return self::load($code);
        }
    }
}
