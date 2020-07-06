<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Name;

/**
 * Resolve namespace names to filesystem file paths
 */
final class FilesystemNameResolver implements NameResolverInterface
{
    public function resolve(NameInterface $baseName, NameInterface $toResolve): NameInterface
    {
        if (is_file($toResolve->getNamespaceName())) {
            return new NamespacedName((string)realpath($toResolve->getNamespaceName()), $toResolve->getShortName());
        }

        $resolved = dirname($baseName->getNamespaceName()) . DIRECTORY_SEPARATOR . $toResolve->getNamespaceName();

        if (is_file($resolved)) {
            return new NamespacedName((string)realpath($resolved), $toResolve->getShortName());
        }

        return $toResolve;
    }
}
