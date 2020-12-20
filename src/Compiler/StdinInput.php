<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

final class StdinInput implements InputInterface
{
    private string $content = '';

    public function getContents(): string
    {
        if (!$this->content && defined('STDIN')) {
            $this->content = (string)stream_get_contents(STDIN);
        }

        if ($this->content) {
            return $this->content;
        }

        throw new \RuntimeException('Unable to read from stdin');
    }

    public function getName(): string
    {
        return 'STDIN';
    }
}
