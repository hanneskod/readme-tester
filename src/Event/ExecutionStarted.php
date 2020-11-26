<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use Symfony\Component\Console\Output\OutputInterface;

final class ExecutionStarted extends LogEvent
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        parent::__construct('Execution started');
        $this->output = $output;
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }
}
