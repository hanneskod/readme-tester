<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Attribute\Isolate;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\Loader;

final class EvalRunner implements RunnerInterface
{
    private const ERROR_CODES = [
        E_ERROR => 'E_ERROR',
        E_WARNING => 'E_WARNING',
        E_PARSE => 'E_PARSE',
        E_NOTICE => 'E_NOTICE',
        E_CORE_ERROR => 'E_CORE_ERROR',
        E_CORE_WARNING => 'E_CORE_WARNING',
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_WARNING => 'E_USER_WARNING',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_STRICT => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED => 'E_DEPRECATED',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        E_ALL => 'E_ALL',
    ];

    public function setBootstrap(string $filename): void
    {
        if ($filename) {
            require_once $filename;
        }
    }

    public function run(ExampleStoreInterface $examples): iterable
    {
        foreach ($examples->getExamples() as $example) {
            if ($example->hasAttribute(Isolate::class)) {
                yield new SkippedOutcome($example, 'requires isolation');
                continue;
            }

            yield $this->runExample($example);
        }
    }

    public function runExample(ExampleObj $example): OutcomeInterface
    {
        $errorOutput = '';

        set_error_handler(
            function (int $errno, string $errstr) use (&$errorOutput) {
                if (($errno & error_reporting()) == $errno) {
                    $errorOutput = sprintf(
                        '%s: %s',
                        self::ERROR_CODES[$errno] ?? '',
                        $errstr
                    );
                }

                return true;
            },
            E_ALL
        );

        ob_start();

        try {
            Loader::loadRaw($example->getCodeBlock()->getCode());
        } catch (\Throwable $exception) {
            restore_error_handler();
            ob_end_clean();
            return new ErrorOutcome($example, (string)$exception);
        }

        restore_error_handler();

        $output = ob_get_clean();

        if ($errorOutput) {
            return new ErrorOutcome($example, $errorOutput);
        }

        if ($output) {
            return new OutputOutcome($example, $output);
        }

        return new VoidOutcome($example);
    }
}
