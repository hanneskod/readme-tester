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
        if ($bootstrap) {
            if (!file_exists($bootstrap)) {
                throw new \RuntimeException("Unable to load bootstrap $bootstrap, file does not exist");
            }
            require_once $bootstrap;
        }
    }

    public function run(ExampleObj $example): OutcomeInterface
    {
        foreach ($example->getAttributes() as $attribute) {
            if ($attribute instanceof Isolate) {
                return new SkippedOutcome('Example skipped as it requires isolation');
            }
        }

        ob_start();

        try {
            $lastErrorBefore = error_get_last();
            Loader::load($example->getCodeBlock()->getCode());
            $lastErrorAfter = error_get_last();
            if ($lastErrorBefore != $lastErrorAfter) {
                ob_end_clean();
                $lastErrorAfterType = $lastErrorAfter['type'] ?? '';
                $lastErrorAfterMessage = $lastErrorAfter['message'] ?? '';
                return new ErrorOutcome("$lastErrorAfterType: $lastErrorAfterMessage");
            }
        } catch (\Throwable $e) {
            ob_end_clean();
            return new ErrorOutcome((string)$e);
        }

        if ($output = ob_get_clean()) {
            return new OutputOutcome($output);
        }

        return new VoidOutcome;
    }
}
