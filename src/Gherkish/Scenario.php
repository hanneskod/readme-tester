<?php
/**
 * The Gherkish subpackage contains experimental support classes to implement
 * feature testing with a Gherkin inspired syntax.
 *
 * WARNING Classes in these package are not covered by semver and may change
 * without notice.
 *
 * See features/ for example usage
 */

declare(strict_types = 1);

namespace hanneskod\readmetester\Gherkish;

final class Scenario
{
    private FeatureContextInterface $featureContext;

    public function __construct(FeatureContextInterface $featureContext) {
        $this->featureContext = $featureContext;
    }

    /** @param array<mixed> $arguments */
    public function __call(string $name, array $arguments): self
    {
        $this->featureContext->do(
            preg_replace('/^[a-zA-Z]+_/', '', $name),
            $arguments
        );

        return $this;
    }
}
