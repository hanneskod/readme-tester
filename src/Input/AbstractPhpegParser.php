<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input;

abstract class AbstractPhpegParser implements ParserInterface
{
    public function parseContent(string $content): ReflectiveExampleStoreTemplate
    {
        return $this->parse($content);
    }

    /**
     * @param string $content
     * @return ReflectiveExampleStoreTemplate
     */
    abstract protected function parse($content);
}
