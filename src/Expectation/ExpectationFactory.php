<?php

namespace hanneskod\readmetester\Expectation;

/**
 * Create expectations from annotation data
 */
class ExpectationFactory
{
    /**
     * Create expectations from annotation data
     *
     * @param  string $name Name of expectation
     * @param  array  $args Expectation data
     * @return ExpectationInterface|null Null if no expectation could be created
     */
    public function createExpectation($name, array $args)
    {
        if (empty($args)) {
            $args[] = '';
        }

        switch (strtolower($name)) {
            case 'expectexception':
                return new ExceptionExpectation($args[0]);
            case 'expectoutput':
                return new OutputExpectation(new Regexp($args[0]));
            case 'expectreturntype':
                return new ReturnTypeExpectation($args[0]);
            case 'expectreturn':
                return new ReturnExpectation(new Regexp($args[0]));
            case 'expectnothing':
                return new NullExpectation;
        }
    }
}
