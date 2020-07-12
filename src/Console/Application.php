<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Symfony single command application
 */
class Application extends \Symfony\Component\Console\Application
{
    /**
     * Gets the name of the command based on input.
     *
     * @param InputInterface $input The input interface
     *
     * @return string The command name
     */
    protected function getCommandName(InputInterface $input): string
    {
        // This should return the name of your command.
        return 'test';
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return array<\Symfony\Component\Console\Command\Command> An array of default Command instances
     */
    protected function getDefaultCommands(): array
    {
        // Keep the core default commands to have the HelpCommand
        // which is used when using the --help option
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new TestCommand();

        return $defaultCommands;
    }

    /**
     * Overridden so that the application doesn't expect the command
     * name to be the first argument.
     */
    public function getDefinition(): \Symfony\Component\Console\Input\InputDefinition
    {
        $inputDefinition = parent::getDefinition();
        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
