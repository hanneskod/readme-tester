<?php

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
            yield basename($this->filename) => $this->readFile($this->filename);
            return;
        }

        foreach (new \DirectoryIterator($this->filename) as $fileInfo) {
            if (in_array(strtolower($fileInfo->getExtension()), ['md', 'mdown', 'markdown'])) {
                yield $fileInfo->getFilename() => $this->readFile($fileInfo->getRealPath());
            }
        }
    }

    private function readFile(string $filename): string
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new \Exception("Not able to read $filename");
        }

        return file_get_contents($filename);
    }
}
