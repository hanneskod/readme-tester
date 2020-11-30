<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Event;
use hanneskod\readmetester\Utils\CodeBlock;
use Psr\EventDispatcher\EventDispatcherInterface;

final class BootstrapFactory
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
    ) {}

    /** @param array<string> $filenames */
    public function createFromFilenames(array $filenames): CodeBlock
    {
        $bootstrap = '';

        foreach ($filenames as $filename) {
            if (!is_file($filename) || !is_readable($filename)) {
                throw new \RuntimeException("Unable to load bootstrap: $filename");
            }

            $this->dispatcher->dispatch(new Event\BootstrapIncluded($filename));

            $bootstrap .= "require_once '" . (string)realpath($filename) . "';\n";
        }

        return new CodeBlock($bootstrap);
    }
}
