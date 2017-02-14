<?php

namespace hanneskod\readmetester\PHPUnit;

class ReadmeIntegration extends ReadmeTestCase
{
    public function testExamples()
    {
        $this->assertReadme(__DIR__ . '/../../');
    }
}
