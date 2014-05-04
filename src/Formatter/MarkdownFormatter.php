<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Formatter;

use hanneskod\exemplify\FormatterInterface;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class MarkdownFormatter implements FormatterInterface
{
    private $headerLevel, $lineWidth, $codeIndentation;

    public function __construct($topHeaderWeight = 1, $lineWidth = 80, $codeIndentation = '')
    {
        $this->headerLevel = $topHeaderWeight;
        $this->lineWidth = $lineWidth;
        $this->codeIndentation = $codeIndentation;
    }

    public function levelUpHeader()
    {
        $this->headerLevel++;
    }

    public function levelDownHeader()
    {
        $this->headerLevel--;
    }

    public function formatHeader($header)
    {
        return str_repeat('#', $this->headerLevel) . " " . trim($header) . "\n\n";
    }

    public function formatText($text)
    {
        $text = str_replace(array("\r\n", "\n", "\r"), ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        assert('is_string($text)');

        return wordwrap($text, $this->lineWidth) . "\n\n";
    }

    public function formatCodeBlock(array $lines)
    {
        $block = (string)new Indentor($lines, $this->codeIndentation);

        if (empty($block)) {
            return "";
        }

        return "```php\n$block```\n\n";
    }
}
