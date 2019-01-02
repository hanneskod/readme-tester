<?php

namespace hanneskod\readmetester\Name;

interface ResolverInterface
{
    /**
     * Resolve name using base namespace
     */
    public function resolve(NameInterface $baseName, NameInterface $toResolve): NameInterface;
}
