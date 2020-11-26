<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

use hanneskod\readmetester\Output;
use hanneskod\readmetester\Runner;

final class Configs
{
    // Input config names

    const INPUT_OPTION = 'input';
    const INPUT_CONFIG = 'input_format';

    const INPUT_ID_MARKDOWN = 'markdown';

    const INPUT_ID = [
        self::INPUT_ID_MARKDOWN => \hanneskod\readmetester\Input\Markdown\MarkdownCompilerFactory::class,
    ];

    // Output config names

    const OUTPUT_OPTION = 'output';
    const OUTPUT_CONFIG = 'output_format';

    const OUTPUT_ID_DEBUG = 'debug';
    const OUTPUT_ID_DEFAULT = 'default';
    const OUTPUT_ID_JSON = 'json';
    const OUTPUT_ID_VOID = 'void';

    const OUTPUT_ID = [
        self::OUTPUT_ID_DEBUG => Output\DebugOutputtingSubscriber::class,
        self::OUTPUT_ID_DEFAULT => Output\DefaultOutputtingSubscriber::class,
        self::OUTPUT_ID_JSON => Output\JsonOutputtingSubscriber::class,
        self::OUTPUT_ID_VOID => Output\VoidOutputtingSubscriber::class,
    ];

    // Runner config names

    const RUNNER_OPTION = 'runner';
    const RUNNER_CONFIG = 'runner';

    const RUNNER_ID_PROCESS = 'process';
    const RUNNER_ID_EVAL = 'eval';

    const RUNNER_ID = [
        self::RUNNER_ID_PROCESS => Runner\ProcessRunner::class,
        self::RUNNER_ID_EVAL => Runner\EvalRunner::class,
    ];

    // Other config names

    const PATHS_ARGUMENT = 'path';
    const PATHS_CONFIG = 'paths';

    const FILE_EXTENSIONS_OPTION = 'file-extension';
    const FILE_EXTENSIONS_CONFIG = 'file_extensions';

    const IGNORE_PATHS_OPTION = 'ignore';
    const IGNORE_PATHS_CONFIG = 'ignore_paths';

    const BOOTSTRAPS_OPTION = 'bootstrap';
    const IGNORE_BOOTSTRAP_OPTION = 'no-bootstrap';
    const BOOTSTRAPS_CONFIG = 'bootstrap';

    const STOP_ON_FAILURE_OPTION = 'stop-on-failure';
    const STOP_ON_FAILURE_CONFIG = 'stop_on_failure';

    const SUBSCRIBERS_CONFIG = 'subscribers';

    // Helpers

    /** @param array<string, string> $map */
    public static function expand(array $map, string $key): string
    {
        if (isset($map[$key])) {
            return $map[$key];
        }

        return $key;
    }

    /** @param array<string, string> $map */
    public static function describe(array $map): string
    {
        return implode(', ', array_keys($map));
    }
}
