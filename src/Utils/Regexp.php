<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Utils;

/**
 * Regular expression container
 */
class Regexp
{
    private string $regexp;

    public function __construct(string $regexp)
    {
        $this->regexp = $this->isRegexp($regexp) ? $regexp : $this->makeRegexp($regexp);
    }

    /**
     * Get expression as string
     */
    public function getRegexp(): string
    {
        return $this->regexp;
    }

    /**
     * Check if this expression matches subject
     */
    public function matches(string $subject): bool
    {
        return !!preg_match($this->regexp, $subject);
    }

    /**
     * Check if string is a regular expression
     */
    private function isRegexp(string $input): bool
    {
        set_error_handler(function () {
        });
        $result = preg_match($input, '');
        restore_error_handler();
        return $result !== false;
    }

    /**
     * Create regular expression from string
     */
    private function makeRegexp(string $input): string
    {
        return sprintf(
            '/^%s$/',
            preg_quote($input)
        );
    }
}
