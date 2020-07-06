<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

final class FileInput implements InputInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getContents(): string
    {
        if (!is_file($this->filename) || !is_readable($this->filename)) {
            throw new \RuntimeException("Not able to read $this->filename");
        }

        return file_get_contents($this->filename);
    }

    public function getDefaultNamespace(): string
    {
        return $this->filename;
    }
}
