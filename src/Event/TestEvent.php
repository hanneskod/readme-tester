<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Expectation\StatusInterface;

abstract class TestEvent extends BaseEvent
{
    private StatusInterface $status;

    public function __construct(StatusInterface $status)
    {
        parent::__construct(
            "[{$status->getOutcome()->getExample()->getName()->getFullName()}] {$status->getContent()}"
        );

        $this->status = $status;
    }

    public function getStatus(): StatusInterface
    {
        return $this->status;
    }
}
