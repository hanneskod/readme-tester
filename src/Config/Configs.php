<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

use hanneskod\readmetester\InputLanguage;
use hanneskod\readmetester\Output;
use hanneskod\readmetester\Runner;

/**
 * Configuration id constants and helper functions
 */
final class Configs
{
    const DEFAULT_SUITE_NAME = 'default';

    const SUITES = 'suites';
    const DEFAULTS = 'defaults';
    const CLI = '__CLI__';

    const ACTIVE = 'active';
    const INCLUDE_PATHS = 'include_paths';
    const EXCLUDE_PATHS = 'exclude_paths';
    const FILE_EXTENSIONS = 'file_extensions';
    const STOP_ON_FAILURE = 'stop_on_failure';
    const FILTER = 'filter';
    const STDIN = 'stdin';
    const GLOBAL_ATTRIBUTES = 'global_attributes';

    const BOOTSTRAP = 'bootstrap';
    const SUBSCRIBERS = 'subscribers';

    const INPUT_LANGUAGE = 'input_language';
    const INPUT_ID_MARKDOWN = 'markdown';
    const INPUT_ID = [
        self::INPUT_ID_MARKDOWN => InputLanguage\Markdown\MarkdownCompilerFactory::class,
    ];

    const OUTPUT = 'output_format';
    const OUTPUT_ID_DEBUG = 'debug';
    const OUTPUT_ID_DEFAULT = 'default';
    const OUTPUT_ID_JSON = 'json';
    const OUTPUT_ID = [
        self::OUTPUT_ID_DEBUG => Output\DebugOutputtingSubscriber::class,
        self::OUTPUT_ID_DEFAULT => Output\DefaultOutputtingSubscriber::class,
        self::OUTPUT_ID_JSON => Output\JsonOutputtingSubscriber::class,
    ];

    const RUNNER = 'runner';
    const RUNNER_ID_EVAL = 'eval';
    const RUNNER_ID_PARALLEL = 'parallel';
    const RUNNER_ID_PROCESS = 'process';
    const RUNNER_ID = [
        self::RUNNER_ID_EVAL => Runner\EvalRunner::class,
        self::RUNNER_ID_PARALLEL => Runner\ParallelRunner::class,
        self::RUNNER_ID_PROCESS => Runner\ProcessRunner::class,
    ];

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
