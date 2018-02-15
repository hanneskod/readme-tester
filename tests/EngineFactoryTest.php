<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

class EngineFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateEngine()
    {
        $this->assertInstanceOf(
            Engine::CLASS,
            (new EngineFactory)->createEngine()
        );
    }
}
