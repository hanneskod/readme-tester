<?php

namespace hanneskod\readmetester;

class ReadmeTest extends \hanneskod\readmetester\ReadmeTestCase
{
    public function testReadmeExamples()
    {
        $this->assertReadme('README.md');
    }
}
