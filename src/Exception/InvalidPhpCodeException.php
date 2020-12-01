<?php

namespace hanneskod\readmetester\Exception;

use hanneskod\readmetester\Exception;

final class InvalidPhpCodeException extends \RuntimeException implements Exception
{
    private string $phpCode;

    public function __construct(string $message, string $phpCode)
    {
        parent::__construct($message);
        $this->phpCode = $phpCode;
    }

    public function getPhpCode(): string
    {
        return $this->phpCode;
    }
}
