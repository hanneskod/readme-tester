<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Config;

use hanneskod\readmetester\InputLanguage;
use hanneskod\readmetester\Output;
use hanneskod\readmetester\Runner;

/**
 * Configuration id constants and helper functions
 */
final class Configs
{
    public const DEFAULT_SUITE_NAME = 'default';

    public const SUITES = 'suites';
    public const DEFAULTS = 'defaults';
    public const CLI = '__CLI__';

    public const ACTIVE = 'active';
    public const INCLUDE_PATHS = 'include_paths';
    public const EXCLUDE_PATHS = 'exclude_paths';
    public const FILE_EXTENSIONS = 'file_extensions';
    public const STOP_ON_FAILURE = 'stop_on_failure';
    public const FILTER = 'filter';
    public const STDIN = 'stdin';
    public const GLOBAL_ATTRIBUTES = 'global_attributes';

    public const BOOTSTRAP = 'bootstrap';
    public const SUBSCRIBERS = 'subscribers';

    public const INPUT_LANGUAGE = 'input_language';
    public const INPUT_ID_MARKDOWN = 'markdown';
    public const INPUT_ID = [
        self::INPUT_ID_MARKDOWN => InputLanguage\Markdown\MarkdownCompilerFactory::class,
    ];

    public const OUTPUT = 'output_format';
    public const OUTPUT_ID_DEBUG = 'debug';
    public const OUTPUT_ID_DEFAULT = 'default';
    public const OUTPUT_ID_JSON = 'json';
    public const OUTPUT_ID = [
        self::OUTPUT_ID_DEBUG => Output\DebugOutputtingSubscriber::class,
        self::OUTPUT_ID_DEFAULT => Output\DefaultOutputtingSubscriber::class,
        self::OUTPUT_ID_JSON => Output\JsonOutputtingSubscriber::class,
    ];

    public const RUNNER = 'runner';
    public const RUNNER_ID_EVAL = 'eval';
    public const RUNNER_ID_PARALLEL = 'parallel';
    public const RUNNER_ID_PROCESS = 'process';
    public const RUNNER_ID = [
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
