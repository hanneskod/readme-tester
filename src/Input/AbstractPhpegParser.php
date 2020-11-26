<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input;

abstract class AbstractPhpegParser implements ParserInterface
{
    public function parseContent(string $content): Template
    {
        return $this->parse($content);
    }

    /**
     * @param string $content
     * @return Template
     */
    abstract protected function parse($content);
}
