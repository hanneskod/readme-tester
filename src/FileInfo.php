<?php

namespace hanneskod\readmetester;

use SplFileInfo;
use RuntimeException;

/**
 * SplFileInfo extension that adds getContents
 */
class FileInfo extends SplFileInfo
{
    /**
     * Get file content
     *
     * @return string
     * @throws RuntimeException If file is not readable
     */
    public function getContents()
    {
        if (!$this->isReadable()) {
            throw new RuntimeException("Unknown file {$this->getBasename()}");
        }
        return file_get_contents($this->getRealPath());
    }
}
