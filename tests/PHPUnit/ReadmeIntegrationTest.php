<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\PHPUnit;

class ReadmeIntegrationTest extends ReadmeTestCase
{
    public function testExamples()
    {
        $this->assertReadme(__DIR__ . '/../../README.md');
    }
}
