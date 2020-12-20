<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Exception\InvalidInputException;

class InvalidInput extends BaseEvent
{
    private string $verboseMessage;

    public function __construct(InvalidInputException $exception)
    {
        $message = sprintf(
            "Failed parsing examples from '%s': %s",
            $exception->getInput()->getName(),
            $exception->getMessage()
        );

        parent::__construct($message);

        $this->verboseMessage = $message . " in\n\n{$exception->getVerboseMessage()}";
    }

    public function getVerboseMessage(): string
    {
        return $this->verboseMessage;
    }
}
