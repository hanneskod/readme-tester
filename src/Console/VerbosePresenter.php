<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

/**
 * Presenter for verbose output
 */
class VerbosePresenter extends Presenter
{
    protected function success(string $exampleName, string $message)
    {
        $this->output->writeln("Example <info>$exampleName</info> OK");
    }
}
