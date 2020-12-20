<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use Symfony\Component\Finder\SplFileInfo;

final class FileIncluded extends BaseEvent
{
    private SplFileInfo $fileInfo;

    public function __construct(SplFileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
        parent::__construct("Including file: {$this->getFilename()}");
    }

    public function getFilename(): string
    {
        return $this->fileInfo->getRelativePathname();
    }

    public function getFileInfo(): SplFileInfo
    {
        return $this->fileInfo;
    }
}
