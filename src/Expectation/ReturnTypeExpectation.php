<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation;
use hanneskod\readmetester\Result;
use UnexpectedValueException;

/**
 * Validate the type of the raturn value
 */
class ReturnTypeExpectation implements Expectation
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
                $this->strategy = function (Result $result) use ($type) {
                    return 0 == strcasecmp(gettype($result->getReturnValue()), $type);
                };
                break;
            default:
                $this->strategy = function (Result $result) use ($type) {
                    return $result->getReturnValue() instanceof $type;
                };
                break;
        }
    }

    /**
     * Validate the type of the raturn value
     *
     * @param  Result $result
     * @return null
     * @throws UnexpectedValueException If return value does not match expected type
     */
    public function validate(Result $result)
    {
        $strategy = $this->strategy;
        if (!$strategy($result)) {
            throw new UnexpectedValueException(
                "Failed asserting return type, found: " . gettype($result->getReturnValue())
            );
        }
    }
}
