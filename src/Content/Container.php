<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Content;

use hanneskod\exemplify\ContentInterface;
use hanneskod\exemplify\FormatterInterface;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Container implements ContentInterface
{
    private $content;

    public function __construct()
    {
        $this->content = func_get_args();
    }

    public function addContent(ContentInterface $content)
    {
        $this->content[] = $content;
    }

    public function format(FormatterInterface $formatter)
    {
        $formatter->levelUpHeader();
        $str = '';
        foreach ($this->content as $content) {
            $str .= $content->format($formatter);
        }
        $formatter->levelDownHeader();

        return $str;
    }
}
