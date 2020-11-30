<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Attribute\Isolate;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Utils\Loader;

final class EvalRunner implements RunnerInterface
{
    public function setBootstrap(CodeBlock $bootstrap): void
    {
        Loader::loadOnce($bootstrap->getCode());
    }

    public function run(ExampleObj $example): OutcomeInterface
    {
        foreach ($example->getAttributes() as $attribute) {
            if ($attribute instanceof Isolate) {
                return new SkippedOutcome('requires isolation');
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
        } catch (\Throwable $exception) {
            restore_error_handler();
            ob_end_clean();
            return new ErrorOutcome((string)$exception);
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
