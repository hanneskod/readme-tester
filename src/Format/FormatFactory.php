<?php

namespace hanneskod\readmetester\Format;

use RuntimeException;

/**
 * Create Readme file format based on identifier
 */
class FormatFactory
{
    /**
     * Create file format
     *
     * @see https://github.com/github/markup
     *
     * @param  string $identifier
     * @return FormatInterface
     * @throws RuntimeException If identifier is not supported
     */
    public function createFormat($identifier)
    {
        switch (strtolower($identifier)) {
            case 'markdown':
                // no break
            case 'mdown':
            case 'mkdn':
            case 'md':
                return new Markdown;
        }
        throw new RuntimeException("Unknown identifier $identifier");
    }
}
