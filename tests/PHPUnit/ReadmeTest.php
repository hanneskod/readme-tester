<?php

namespace hanneskod\readmetester\PHPUnit;

/**
 * @covers hanneskod\readmetester\PHPUnit\ReadmeTestCase
 */
class ReadmeTest extends \hanneskod\readmetester\PHPUnit\ReadmeTestCase
{
    public function testReadmeExamples()
    {
        $this->assertReadme(__DIR__ . '/../../README.md');
    }
}
