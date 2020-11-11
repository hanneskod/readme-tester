<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Attributes\Isolate;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\Loader;

final class EvalRunner implements RunnerInterface
{
    public function __construct(string $bootstrap = '')
    {
        Loader::loadOnce($bootstrap);
    }

    public function run(ExampleObj $example): OutcomeInterface
    {
        foreach ($example->getAttributes() as $attribute) {
            if ($attribute instanceof Isolate) {
                return new SkippedOutcome('Example skipped as it requires isolation');
            }
        }

        $errorOutput = '';

        set_error_handler(
            function (int $errno, string $errstr) use (&$errorOutput) {
                $errorOutput = $errstr;
                return true;
            },
            E_ALL
        );

        ob_start();

        try {
            Loader::load($example->getCodeBlock()->getCode());
        } catch (\Throwable $e) {
            restore_error_handler();
            ob_end_clean();
            return new ErrorOutcome((string)$e);
        }

        restore_error_handler();

        $output = ob_get_clean();

        if ($errorOutput) {
            return new ErrorOutcome($errorOutput);
        }

        if ($output) {
            return new OutputOutcome($output);
        }

        return new VoidOutcome;
    }
}
