<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

/**
 * Regular expression container
 */
class Regexp
{
    /**
     * @var string Regular expression
     */
    private $regexp;

    public function __construct(string $regexp)
    {
        $this->regexp = $this->isRegexp($regexp) ? $regexp : $this->makeRegexp($regexp);
    }

    /**
     * Get expression as string
     */
    public function __toString(): string
    {
        return $this->regexp;
    }

    /**
     * Check if this expression matches subject
     */
    public function isMatch(string $subject): bool
    {
        return !!preg_match($this->regexp, $subject);
    }

    /**
     * Check if string is a regular expression
     */
    private function isRegexp(string $input): bool
    {
        set_error_handler(function() {});
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
