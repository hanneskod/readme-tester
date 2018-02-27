<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

/**
 * The collection of annotation names
 */
interface Annotations
{
    /**
     * Prepend snippet to all following examples in the current setting (file)
     */
    const ANNOTATION_CONTEXT = 'exampleContext';

    /**
     * Signal that the following snippet is an example
     *
     * Use optional argument to specify an example name
     */
    const ANNOTATION_EXAMPLE = 'example';

    /**
     * Do not run the following example when testing
     */
    const ANNOTATION_IGNORE = 'ignore';

    /**
     * Include a named example in the current one
     */
    const ANNOTATION_INCLUDE = 'include';

    /**
     * Expect the the snippet produces output
     *
     * Use optional argument to specify what output should be produced
     */
    const ANNOTATION_EXPECT_OUTPUT = 'expectOutput';

    /**
     * Expect the the snippet errors
     *
     * Use optional argument to specify the error text
     */
    const ANNOTATION_EXPECT_ERROR = 'expectError';
}
