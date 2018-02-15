<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Expectation\Status;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Default text output formatter
 */
class JsonFormatter implements FormatterInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $keys;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function onInvokationStart(): void
    {
        $this->data = [
            'bootstrap' => '',
            'tests' => [],
            'counts' => [
                'files' => 0,
                'examples' => 0,
                'ignored' => 0,
                'assertions' => 0,
                'failures' => 0,
            ]
        ];
    }

    public function onBootstrap(string $filename): void
    {
        $this->data['bootstrap'] = $filename;
    }

    public function onFile(string $filename): void
    {
        $this->data['tests'][$filename] = [];
        $this->data['counts']['files']++;
        $this->keys['file'] = $filename;
    }

    public function onExample(Example $example): void
    {
        $this->data['tests'][$this->keys['file']][$example->getName()] = [];
        $this->data['counts']['examples']++;
        $this->keys['example'] = $example->getName();
    }

    public function onIgnoredExample(Example $example): void
    {
        $this->data['tests'][$this->keys['file']][$example->getName()] = 'IGNORED';
        $this->data['counts']['ignored']++;
    }

    public function onExpectation(Status $status): void
    {
        $this->data['tests'][$this->keys['file']][$this->keys['example']][] = [
            $status->isSuccess() ? 'success' : 'failure' => (string)$status
        ];

        $this->data['counts']['assertions']++;

        if (!$status->isSuccess()) {
            $this->data['counts']['failures']++;
        }
    }

    public function onInvokationEnd(): void
    {
        $this->output->writeln(json_encode($this->data, JSON_PRETTY_PRINT));
    }
}
