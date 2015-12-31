<?php

namespace hanneskod\readmetester\Expectation;

/**
 * Create expectations
 */
class Factory
{
    /**
     * Create expectations
     *
     * @param  string $name Name of expectation
     * @param  mixed  $data Expectation data
     * @return ExpectationInterface|null Null if no expectation could be created
     */
    public function createExpectation($name, $data)
    {
        switch (strtolower($name)) {
            case 'expectexception':
                return new ExceptionExpectation($data);
            case 'expectoutput':
                return new OutputExpectation(new Regexp($data));
            case 'expectreturntype':
                return new ReturnTypeExpectation($data);
            case 'expectreturn':
                return new ReturnExpectation(new Regexp($data));
            case 'expectnothing':
                return new NullExpectation;
        }
    }
}
