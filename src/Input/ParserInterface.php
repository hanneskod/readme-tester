<?php

namespace hanneskod\readmetester\Input;

interface ParserInterface
{
    public function parseContent(string $content): Template;
}
