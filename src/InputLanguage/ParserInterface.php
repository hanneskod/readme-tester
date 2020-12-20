<?php

namespace hanneskod\readmetester\InputLanguage;

interface ParserInterface
{
    public function parseContent(string $content): ReflectiveExampleStoreTemplate;
}
