<?php

namespace hanneskod\readmetester;

use hanneskod\readmetester\Format\Markdown;
use RuntimeException;

/**
 * Create Readme file format based on extension
 */
class FormatFactory
{
    /**
     * Create Readme file format based on extension
     *
     * @see https://github.com/github/markup
     *
     * @param  \SplFileObject $file
     * @return Format
     * @throws RuntimeException If file extension is not supported
     */
    public function createFormat(\SplFileObject $file)
    {
        switch (strtolower($file->getExtension())) {
            case 'markdown':
            case 'mdown':
            case 'mkdn':
            case 'md':
                return new Markdown;
        }
        throw new RuntimeException("Unknown file extension .{$file->getExtension()}");
    }
}
