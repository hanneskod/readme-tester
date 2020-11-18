<?php

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Output\OutputInterface;

interface OutputAwareInterface
{
    public function setOutput(OutputInterface $output): void;
}
