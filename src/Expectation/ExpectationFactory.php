<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Annotation;

/**
 * Create expectations from annotation data
 */
class ExpectationFactory
{
    public function createExpectation(Annotation $annotation): ?ExpectationInterface
    {
        if ($annotation->isNamed('expectException')) {
            return new ExceptionExpectation($annotation->getArgument());
        }

        if ($annotation->isNamed('expectOutput')) {
            return new OutputExpectation(new Regexp($annotation->getArgument()));
        }

        if ($annotation->isNamed('expectReturnType')) {
            return new ReturnTypeExpectation($annotation->getArgument());
        }

        if ($annotation->isNamed('expectReturn')) {
            return new ReturnExpectation(new Regexp($annotation->getArgument()));
        }

        if ($annotation->isNamed('expectNothing')) {
            return new NullExpectation;
        }

        return null;
    }
}
