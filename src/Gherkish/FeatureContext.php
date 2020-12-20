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

declare(strict_types=1);

namespace hanneskod\readmetester\Gherkish;

final class FeatureContext
{
    /** @var array<string, \Closure> */
    private array $steps = [];

    /** @var array<string, mixed> */
    private array $properties = [];

    private \Closure $onTeardown;

    /**
     * Register closure to be called before step registration
     */
    public function setup(\Closure $setup): self
    {
        $setup = $setup->bindTo($this);

        if (!$setup) {
            throw new \LogicException('Unable to register setup');
        }

        $setup();

        return $this;
    }

    /**
     * Register closure to be called after scenario execution
     */
    public function teardown(\Closure $teardown): self
    {
        $teardown = $teardown->bindTo($this);

        if (!$teardown) {
            throw new \LogicException('Unable to register teardown');
        }

        $this->onTeardown = $teardown;

        return $this;
    }

    /**
     * Register step
     */
    public function on(string $name, \Closure $step): self
    {
        $step = $step->bindTo($this);

        if (!$step) {
            throw new \LogicException('Unable to register step');
        }

        $this->steps[strtolower($name)] = $step;

        return $this;
    }

    /**
     * Register step using method overloading
     *
     * @param array<mixed> $arguments
     */
    public function __call(string $name, array $arguments): self
    {
        $step = $arguments[0] ?? null;

        if (!$step instanceof \Closure) {
            throw new \LogicException('Step must be registered with a closure');
        }

        return $this->on($name, $step);
    }

    /**
     * Execute step
     *
     * @param array<mixed> $arguments
     */
    public function do(string $name, array $arguments): void
    {
        $name = strtolower($name);

        if (!isset($this->steps[$name])) {
            throw new \Exception("No step $name");
        }

        ($this->steps[$name])(...$arguments);
    }

    public function __destruct()
    {
        if (isset($this->onTeardown)) {
            ($this->onTeardown)();
        }
    }

    public function __set(string $name, mixed $value): void
    {
        $this->properties[$name] = $value;
    }

    public function &__get(string $name): mixed
    {
        if (!isset($this->properties[$name])) {
            throw new \Exception("no propery $name");
        }

        return $this->properties[$name];
    }

    /**
     * Get scenario for configuration
     */
    public function getScenario(): Scenario
    {
        return new Scenario($this);
    }
}
