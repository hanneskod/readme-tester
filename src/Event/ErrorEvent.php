<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Config\Suite;

final class ErrorEvent extends BaseEvent
{
    private \Exception $exception;

    public function __construct(\Exception $exception)
    {
        parent::__construct($exception->getMessage());
        $this->exception = $exception;
    }

    public function getException(): \Exception
    {
        return $this->exception;
    }
}
