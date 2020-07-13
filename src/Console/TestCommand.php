<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\ExampleTester;
use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\EvalRunner;
use hanneskod\readmetester\Runner\ProcessRunner;
use hanneskod\readmetester\Utils\Regexp;
use Symfony\Component\Finder\Finder;

/**
 * CLI command to run test
 */
class TestCommand extends Command
{
    /**
     * Path to default bootstrap file
     */
    const DEFAULT_BOOTSTRAP = 'vendor/autoload.php';

    protected function configure(): void
    {
        $this->setName('test')
            ->setDescription('Test examples in readme file')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to scan for test files',
                []
            )
            ->addOption(
                'file-extension',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'File extension to use while scanning for test files',
                ['md', 'mdown', 'markdown']
            )
            ->addOption(
                'ignore',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Path to ignore while scanning for test files',
                ['vendor']
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_REQUIRED,
                'Set output format (default or json)',
                'default'
            )
            ->addOption(
                'runner',
                null,
                InputOption::VALUE_REQUIRED,
                'Specify the example runner to use (process or eval)',
                'process'
            )
            ->addOption(
                'bootstrap',
                null,
                InputOption::VALUE_REQUIRED,
                'A "bootstrap" PHP file that is run before testing'
            )
            ->addOption(
                'no-auto-bootstrap',
                null,
                InputOption::VALUE_NONE,
                "Don't try to load a local composer autoloader when boostrap is not definied"
            )
            ->addOption(
                'stop-on-failure',
                's',
                InputOption::VALUE_NONE,
                "Stop processing on first failed test"
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $formatter = $input->getOption('format') == 'json'
            ? new JsonFormatter($output)
            : new DefaultFormatter($output);

        $formatter->onInvokationStart();

        if ($bootstrap = $this->readBootstrap($input)) {
            $formatter->onBootstrap($bootstrap);
        }

        /** @var RunnerInterface */
        $runner = null;

        switch ($input->getOption('runner')) {
            case 'process':
                $runner = new ProcessRunner($bootstrap);
                break;
            case 'eval':
                $runner = new EvalRunner($bootstrap);
                break;
            default:
                /** @var string */
                $runnerId = $input->getOption('runner');
                throw new \RuntimeException("Unknown runner '$runnerId'");
        }

        $tester = new ExampleTester(
            $runner,
            new ExpectationEvaluator,
            (bool)$input->getOption('stop-on-failure')
        );

        $tester->registerListener($formatter);

        $exitStatus = new ExitStatusListener;

        $tester->registerListener($exitStatus);

        $finder = (new Finder)->files()->in('.')->ignoreUnreadableDirs();

        // Set paths to scan
        $finder->path(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/',
                (array)$input->getArgument('path')
            )
        );

        // Set file extensions (case insensitive)
        $finder->name(
            array_map(
                fn($extension) => '/\\.' . preg_quote($extension, '/') . '$/i',
                (array)$input->getOption('file-extension')
            )
        );

        // Set paths to ignore
        $finder->notPath(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/',
                (array)$input->getOption('ignore')
            )
        );

        $exampleFactory = new ExampleFactory(new ExpectationFactory);

        $parser = new Parser;

        $examples = [];

        foreach ($finder as $file) {
            //TODO replace with FoundFileEvent...
            $formatter->onFile($file->getRelativePathname());

            $examples = [
                ...$examples,
                ...$exampleFactory->createExamples(...$parser->parse($file->getContents()))->getExamples()
            ];
        }

        $tester->test(new ArrayExampleStore($examples));

        $formatter->onInvokationEnd();

        return $exitStatus->getStatusCode();
    }

    private function readBootstrap(InputInterface $input): string
    {
        /** @var string */
        $filename = $input->getOption('bootstrap');

        if ($filename) {
            if (!is_file($filename) || !is_readable($filename)) {
                throw new \RuntimeException("Unable to bootstrap $filename");
            }

            return (string)realpath($filename);
        }

        if (!$input->getOption('no-auto-bootstrap') && is_readable(self::DEFAULT_BOOTSTRAP)) {
            return (string)realpath(self::DEFAULT_BOOTSTRAP);
        }

        return '';
    }
}
