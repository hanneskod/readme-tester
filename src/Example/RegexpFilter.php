<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\Regexp;

/**
 * Filter examples matching a regular expression string
 */
class RegexpFilter implements FilterInterface
{
    /**
     * @var Regexp
     */
    private $regexp;

    public function __construct(string $rawRegexp)
    {
        $this->regexp = new Regexp($rawRegexp);
    }

    public function isValid(string $name): bool
    {
        return $this->regexp->isMatch($name);
    }
}
