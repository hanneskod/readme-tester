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

final class FeatureContext implements FeatureContextInterface
{
    /** @var array<string, \Closure> */
    private array $steps = [];

    /** @var array<string, mixed> */
    private array $properties = [];

    private \Closure $onTeardown;

    public function setup(\Closure $setup): self
    {
        $setup = $setup->bindTo($this);

        $setup();

        return $this;
    }

    public function teardown(\Closure $teardown): self
    {
        $this->onTeardown = $teardown->bindTo($this);

        return $this;
    }

    public function on(string $name, \Closure $step): self
    {
        $this->steps[strtolower($name)] = $step->bindTo($this);

        return $this;
    }

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

    public function getScenario(): Scenario
    {
        return new Scenario($this);
    }
}
