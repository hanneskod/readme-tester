<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Name;

/**
 * Resolve namespace names to filesystem file paths
 */
final class FilesystemResolver implements ResolverInterface
{
    public function resolve(NameInterface $baseName, NameInterface $toResolve): NameInterface
    {
        if (is_file($toResolve->getNamespaceName())) {
            return new ExampleName($toResolve->getShortName(), (string)realpath($toResolve->getNamespaceName()));
        }

        $resolved = dirname($baseName->getNamespaceName()) . DIRECTORY_SEPARATOR . $toResolve->getNamespaceName();

        if (is_file($resolved)) {
            return new ExampleName($toResolve->getShortName(), (string)realpath($resolved));
        }

        return $toResolve;
    }
}
