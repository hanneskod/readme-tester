<?php

namespace hanneskod\readmetester\Compiler;

interface InputInterface
{
    public function getContents(): string;

    public function getDefaultNamespace(): string;
}
