<?php

namespace hanneskod\readmetester;

use SplFileInfo;

/**
 * SplFileInfo extension that adds getContents
 */
class FileInfo extends SplFileInfo
{
    /**
     * Get file content
     *
     * @return string
     */
    public function getContents()
    {
        return file_get_contents($this->getRealPath());
    }
}
