<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\exemplify\Config\ClassFinder;
use hanneskod\exemplify\Config\Configuration;
use hanneskod\exemplify\Formatter\MarkdownFormatter;
use hanneskod\exemplify\Content\Container;
use hanneskod\exemplify\Content\Header;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Command extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Execute exemplify')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'Path to exemplify file(s)'
            )
            ->addOption(
                'headline',
                null,
                InputOption::VALUE_REQUIRED,
                'Main headline'
            )
            ->addOption(
                'headerWeight',
                null,
                InputOption::VALUE_REQUIRED,
                'Level of first headline',
                1
            )
            ->addOption(
                'lineWidth',
                null,
                InputOption::VALUE_REQUIRED,
                'Markdown line width',
                80
            )
            ->addOption(
                'indent',
                null,
                InputOption::VALUE_REQUIRED,
                'String used for indenting code blocks',
                ''
            )
            ->addOption(
                'config',
                null,
                InputOption::VALUE_REQUIRED,
                'Phpunit configuration file'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Find classes specified at command line
        $path = $input->getArgument('path');
        $classes = ClassFinder::find($path);

        // Phpunit configuration files
        $possibleConfigs = array(
            $input->getOption('config'),
            'phpunit.xml',
            'phpunit.xml.dist'
        );

        // Find classes specified in phpunit configuration
        foreach ($possibleConfigs as $filename) {
            if (is_file($filename)) {
                $config = new Configuration($filename, $path);
                $classes = array_merge(
                    $classes,
                    ClassFinder::find($config->getTestFiles())
                );
                break;
           }
        }

        // Create formatter
        $formatter = new MarkdownFormatter(
            $input->getOption('headerWeight'),
            $input->getOption('lineWidth'),
            $input->getOption('indent')
        );

        // Needed since content is wrapped in container
        $formatter->levelDownHeader();

        $container = new Container;

        // Add top headline if specified
        if ($header = $input->getOption('headline')) {
            $container->addContent(new Header($header));
        } else {
            $formatter->levelDownHeader();
        }

        // Add examples
        foreach ($classes as $class) {
            $obj = new $class();
            $container->addContent($obj->exemplify());
        }

        // Format and output
        $output->write(
            $container->format($formatter)
        );
    }
}
