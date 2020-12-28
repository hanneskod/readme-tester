<?php

declare(strict_types=1);

namespace hanneskod\readmetester;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;

class FilesystemFacade
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
    ) {}

    /**
     * @param array<string> $paths
     * @param array<string> $extensions
     * @param array<string> $ignore
     * @return iterable<Compiler\InputInterface>
     */
    public function getFilesystemInput(string $cwd, array $paths, array $extensions, array $ignore): iterable
    {
        $finder = (new Finder())->files()->in($cwd)->ignoreUnreadableDirs();

        // Set paths to scan

        $finder->path(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/i',
                $paths
            )
        );

        // Set file extensions

        $finder->name(
            array_map(
                fn($extension) => '/\\.' . preg_quote($extension, '/') . '$/i',
                $extensions
            )
        );

        // Set paths to ignore

        $finder->notPath(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/i',
                $ignore
            )
        );

        foreach ($finder as $file) {
            yield new Compiler\FileInput($file);
            $this->dispatcher->dispatch(new Event\FileIncluded($file));
        }
    }
}
