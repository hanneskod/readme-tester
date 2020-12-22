<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Output;

use hanneskod\readmetester\Event;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractOutputtingSubscriber
{
    private ?OutputInterface $output;

    public function onErrorEvent(Event\ErrorEvent $event): void
    {
        $this->getOutput()->writeln("<error>{$event->getMessage()}</error>");

        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln("<error>{$event->getException()}</error>");
        }
    }

    public function getOutput(): OutputInterface
    {
        if (!isset($this->output)) {
            throw new \LogicException('Unable to get output, did you call setOutput()?');
        }

        return $this->output;
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }
}
