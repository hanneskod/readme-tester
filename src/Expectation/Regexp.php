<?php

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

    public function __construct($regexp)
    {
        $this->regexp = $this->isRegexp($regexp) ? $regexp : $this->makeRegexp($regexp);
    }

    /**
     * Get expression as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->regexp;
    }

    /**
     * Check if this expression matches subject
     *
     * @param  string $subject
     * @return bool
     */
    public function isMatch($subject)
    {
        return !!preg_match($this->regexp, $subject);
    }

    /**
     * Check if string is a regular expression
     *
     * @param  string $input
     * @return bool
     */
    private function isRegexp($input)
    {
        set_error_handler(function() {});
        $result = preg_match($input, '');
        restore_error_handler();
        return $result !== false;
    }

    /**
     * Create regular expression from string
     *
     * @param  string $input
     * @return string
     */
    private function makeRegexp($input)
    {
        return sprintf(
            '/^%s$/',
            preg_quote($input)
        );
    }
}
