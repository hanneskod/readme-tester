<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Formatter;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Indentor
{
    private $str = '';

    /**
     * @param array  $lines
     * @param string $indent String use when indenting
     */
    public function __construct(array $lines, $indent = '    ')
    {
        $currentIndentation = 100;

        // Pass one: analyze
        foreach ($lines as &$line) {
            // Remove tabs
            $line = str_replace(array("\t"), $indent, $line);

            // Calc the current indentation in spaces
            $lineIndentation = $this->getIndentation($line);
            if ($lineIndentation < $currentIndentation) {
                $currentIndentation = $lineIndentation;
            }
        }

        $currentIndentation = str_repeat(' ', $currentIndentation);

        // Pass two: fix indentation
        foreach ($lines as &$line) {
            $this->str .= $indent . preg_replace("/^$currentIndentation/", '', $line);
        }
    }

    public function getIndentation($line)
    {
        if (preg_match('/^(\s*)/', $line, $matches)) {
            return strlen($matches[1]);
        }
        return 0;
    }

    public function __tostring()
    {
        return $this->str . "\n";
    }
}
