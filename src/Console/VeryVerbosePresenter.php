<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

/**
 * Presenter for very verbose output
 */
class VeryVerbosePresenter extends VerbosePresenter
{
    protected function success(string $exampleName, string $message)
    {
        $this->output->writeln("Example <info>$exampleName</info>: $message");
    }
}
