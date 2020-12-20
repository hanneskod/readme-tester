<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Utils;

use Psr\Container\ContainerInterface;

class Instantiator implements ContainerInterface
{
    /** @var array<string, object> */
    private array $cache = [];

     /**
      * Implements ContainerInterface
      *
      * @param string $id
      * @return object
      */
    public function get($id)
    {
        return $this->getSharedObject($id);
    }

    /**
     * Implements ContainerInterface
     *
     * @param string $id
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->cache[$id]);
    }

    public function getNewObject(string $classname): object
    {
        if (!class_exists($classname)) {
            throw new \RuntimeException("Class '$classname' does not exist");
        }

        $reflector = new \ReflectionClass($classname);

        if (!$reflector->isInstantiable()) {
            throw new \RuntimeException("Unable to instantiate non-instantiable class '$classname'");
        }

        $constructor = $reflector->getConstructor();

        if ($constructor && $constructor->getNumberOfRequiredParameters()) {
            throw new \RuntimeException("Unable to instantiate '$classname' with no parameters");
        }

        return new $classname;
    }

    public function getSharedObject(string $classname): object
    {
        if (!isset($this->cache[$classname])) {
            $this->cache[$classname] = $this->getNewObject($classname);
        }

        return $this->cache[$classname];
    }
}
