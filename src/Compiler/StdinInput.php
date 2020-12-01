<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

final class StdinInput implements InputInterface
{
    public function getContents(): string
    {
        if (defined('STDIN')) {
            return (string)stream_get_contents(STDIN);
        }

        throw new \RuntimeException('Unable to read from stdin');
    }

    public function getName(): string
    {
        return 'STDIN';
    }
}
