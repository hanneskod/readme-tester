<?php

namespace hanneskod\readmetester;

/**
 * Create expectations
 */
class ExpectationFactory
{
    /**
     * Create expectations
     *
     * @param  string $name Name of expectation
     * @param  mixed  $data Expectation data
     * @return Expectation|null Null if no expectation could be created
     */
    public function createExpectation($name, $data)
    {
        switch (strtolower($name)) {
            case 'expectexception':
                return new Expectation\ExceptionExpectation($data);
            case 'expectoutput':
                return new Expectation\OutputExpectation(new Regexp($data));
            case 'expectreturntype':
                return new Expectation\ReturnTypeExpectation($data);
            case 'expectreturn':
                return new Expectation\ReturnExpectation(new Regexp($data));
            case 'expectnothing':
                return new Expectation\EmptyExpectation;
        }
    }
}
