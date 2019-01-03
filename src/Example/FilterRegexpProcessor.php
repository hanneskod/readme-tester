<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Utils\Regexp;

/**
 * Filter examples matching a regular expression string
 */
final class FilterRegexpProcessor implements ProcessorInterface
{
    /** @var Regexp */
    private $regexp;

    public function __construct(Regexp $regexp)
    {
        $this->regexp = $regexp;
    }

    public function process(ExampleInterface $example): ExampleInterface
    {
        if (!$this->regexp->isMatch($example->getName()->getShortName())) {
            return $example->withActive(false);
        }

        return $example;
    }
}
