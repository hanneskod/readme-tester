<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use hanneskod\readmetester\Compiler;
use hanneskod\readmetester\DependencyInjection;
use hanneskod\readmetester\Event;
use Symfony\Component\Finder\Finder;

final class FilesystemInputGenerator
{
    use DependencyInjection\DispatcherProperty;

    /**
     * @param array<string> $paths
     * @param array<string> $extensions
     * @param array<string> $ignore
     * @return array<Compiler\InputInterface>
     */
    public function generateFilesystemInput(string $cwd, array $paths, array $extensions, array $ignore): array
    {
        $finder = (new Finder)->files()->in($cwd)->ignoreUnreadableDirs();

        // Set paths to scan

        $finder->path(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/',
                $paths
            )
        );

        // Set file extensions (case insensitive)

        $finder->name(
            array_map(
                fn($extension) => '/\\.' . preg_quote($extension, '/') . '$/i',
                $extensions
            )
        );

        // Set paths to ignore

        $finder->notPath(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/',
                $ignore
            )
        );

        // TODO borde kunna returnera en generator...

        $inputs = [];

        foreach ($finder as $file) {
            $inputs[] = new Compiler\FileInput($file);
            $this->dispatcher->dispatch(new Event\FileIncluded($file));
        }

        return $inputs;
    }
}
