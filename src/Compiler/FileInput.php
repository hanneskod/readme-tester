<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Compiler;

use Symfony\Component\Finder\SplFileInfo;

final class FileInput implements InputInterface
{
    private SplFileInfo $fileInfo;

    public function __construct(SplFileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    public function getContents(): string
    {
        return $this->fileInfo->getContents();
    }

    public function getName(): string
    {
        return $this->fileInfo->getRelativePathname();
    }
}
