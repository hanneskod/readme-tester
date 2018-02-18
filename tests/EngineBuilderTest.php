<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

class EngineBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testBuildEngine()
    {
        $this->assertInstanceOf(
            Engine::CLASS,
            (new EngineBuilder)->buildEngine()
        );
    }
}
