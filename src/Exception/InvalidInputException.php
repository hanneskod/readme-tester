<?php

namespace hanneskod\readmetester\Exception;

use hanneskod\readmetester\Exception;
use hanneskod\readmetester\Compiler\InputInterface;

final class InvalidInputException extends \RuntimeException implements Exception
{
    private InputInterface $input;
    private string $verboseMessage;

    public function __construct(string $message, InputInterface $input, string $verboseMessage = '')
    {
        parent::__construct($message);
        $this->input = $input;
        $this->verboseMessage = $verboseMessage;
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }

    public function getVerboseMessage(): string
    {
        return $this->verboseMessage;
    }
}
