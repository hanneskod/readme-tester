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

/**
 * Acts as a wrapper for multiple contexts, each with a separate setup
 */
final class PermutableFeatureContext implements FeatureContextInterface
{
    /** @var array<FeatureContextInterface> */
    private array $permutations = [];

    private bool $locked = false;

    public function addPermutation(\Closure $setup): self
    {
        if ($this->locked) {
            throw new \Exception('Unable to add permutation to locked context');
        }

        $permutation = new FeatureContext;

        $permutation->setup($setup);

        $this->permutations[] = $permutation;

        return $this;
    }

    public function setup(\Closure $setup): self
    {
        foreach ($this->getPermutations() as $permutation) {
            $permutation->setup($setup);
        }

        return $this;
    }

    public function teardown(\Closure $teardown): self
    {
        foreach ($this->getPermutations() as $permutation) {
            $permutation->teardown($teardown);
        }

        return $this;
    }

    public function on(string $name, \Closure $step): self
    {
        foreach ($this->getPermutations() as $permutation) {
            $permutation->on($name, $step);
        }

        return $this;
    }

    public function do(string $name, array $arguments): void
    {
        foreach ($this->getPermutations() as $permutation) {
            $permutation->do($name, $arguments);
        }
    }

    public function getScenario(): Scenario
    {
        return new Scenario($this);
    }

    /** @return array<FeatureContextInterface> */
    private function getPermutations(): array
    {
        $this->locked = true;

        if (empty($this->permutations)) {
            throw new \Exception('No permutations specified, did you call addPermutation()?');
        }

        return $this->permutations;
    }
}
