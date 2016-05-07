<?php

namespace hanneskod\readmetester\PHPUnit;

class ReadmeIntegration extends ReadmeTestCase
{
    public function testReadmeExamples()
    {
        $this->assertReadme(__DIR__ . '/../../README.md');
    }
}
