<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface FormatterInterface
{
    /**
     * @return void
     */
    public function levelUpHeader();

    /**
     * @return void
     */
    public function levelDownHeader();

    /**
     * @param  string $header
     * @return string
     */
    public function formatHeader($header);

    /**
     * @param  string $text
     * @return string
     */
    public function formatText($text);

    /**
     * @param  array  $lines
     * @return string
     */
    public function formatCodeBlock(array $lines);
}
