<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

/**
 * Iterate over markdown formatted source files
 */
class SourceFileIterator implements \IteratorAggregate
{
    /**
     * @var string Source file or directory name
     */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getIterator(): \Traversable
    {
        if (is_file($this->filename)) {
            yield $this->filename => $this->readFile($this->filename);
            return;
        }

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->filename)) as $fileInfo) {
            $basePath = (string)realpath($this->filename);
            if (in_array(strtolower($fileInfo->getExtension()), ['md', 'mdown', 'markdown'])) {
                $displayPath = rtrim($this->filename, '/') . str_replace($basePath, '', $fileInfo->getRealPath());
                yield $displayPath => $this->readFile($fileInfo->getRealPath());
            }
        }
    }

    private function readFile(string $filename): string
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new \Exception("Not able to read $filename");
        }

        return (string)file_get_contents($filename);
    }
}
