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

namespace hanneskod\readmetester\Gherkish;

interface FeatureContextInterface
{
    /**
     * Register closure to be called before step registration
     */
    public function setup(\Closure $setup): self;

    /**
     * Register closure to be called after scenario execution
     */
    public function teardown(\Closure $teardown): self;

    /**
     * Register step
     */
    public function on(string $name, \Closure $step): self;

    /**
     * Execute step
     *
     * @param array<mixed> $arguments
     */
    public function do(string $name, array $arguments): void;

    /**
     * Get scenario for configuration
     */
    public function getScenario(): Scenario;
}
