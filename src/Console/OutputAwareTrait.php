<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Output\OutputInterface;

trait OutputAwareTrait
{
    private ?OutputInterface $output;

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    protected function getOutput(): OutputInterface
    {
        if (!isset($this->output)) {
            throw new \LogicException('Unable to get output, did you call setOutput()?');
        }

        return $this->output;
    }
}
