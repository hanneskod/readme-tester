<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

/**
 * Validate the type of the raturn value
 */
class ReturnTypeExpectation implements ExpectationInterface
{
    /**
     * @var callable Validation strategy
     */
    private $strategy;

    /**
     * Set expected return type
     *
     * @param string $type
     */
    public function __construct($type)
    {
        switch (strtolower($type)) {
            case 'boolean':
            case 'integer':
            case 'double':
            case 'string':
            case 'array':
            case 'object':
            case 'resource':
            case 'null':
                $this->strategy = function(Result $result) use ($type) {
                    return 0 == strcasecmp(gettype($result->getReturnValue()), $type);
                };
                break;
            default:
                $this->strategy = function(Result $result) use ($type) {
                    return $result->getReturnValue() instanceof $type;
                };
                break;
        }
    }

    /**
     * Validate the type of the raturn value
     */
    public function validate(Result $result)
    {
        $strategy = $this->strategy;

        if (!$strategy($result)) {
            return new ReturnObj\Failure(
                "Failed asserting return type, found: ".gettype($result->getReturnValue())
            );
        }

        return new ReturnObj\Success(
            "Asserted return type ".gettype($result->getReturnValue())
        );
    }
}
