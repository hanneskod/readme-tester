<?php

namespace hanneskod\readmetester\Format;

/**
 * Interface for identifying readme file formats
 */
interface FormatInterface
{
    /**
     * Check if line is the start of an example block
     *
     * @param  string $line
     * @return bool
     */
    public function isExampleStart($line);

    /**
     * Check if line is the end of an example block
     *
     * @param  string $line
     * @return bool
     */
    public function isExampleEnd($line);
}
