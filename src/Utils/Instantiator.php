<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Utils;

final class Instantiator
{
    public static function instantiate(string $classname): object
    {
        if (!class_exists($classname)) {
            throw new \RuntimeException("Class '$classname' does not exist");
        }

        $reflector = new \ReflectionClass($classname);

        if (!$reflector->isInstantiable()) {
            throw new \RuntimeException("Unable to instantiate non-instantiable class '$classname'");
        }

        $constructor = $reflector->getConstructor();

        if ($constructor && $constructor->getNumberOfParameters()) {
            throw new \RuntimeException("Unable to instantiate '$classname' with no parameters");
        }

        return new $classname;
    }
}
