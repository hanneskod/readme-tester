<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester\Engine;
use hanneskod\readmetester\EngineBuilder;
use hanneskod\readmetester\SourceFileIterator;
use hanneskod\readmetester\Runner\EvalRunner;
use PHPUnit\Framework\TestCase;

class AssertReadme
{
    /**
     * @var Engine
     */
    private $engine;

    public function __construct(TestCase $testCase, Engine $engine = null)
    {
        $this->engine = $engine ?: (new EngineBuilder)->setRunner(new EvalRunner)->buildEngine();
        $this->engine->registerListener(new PhpunitListener($testCase));
    }

    public function assertReadme(string $source)
    {
        foreach (new SourceFileIterator($source) as $fileName => $contents) {
            $this->engine->testFile($contents);
        }
    }
}
