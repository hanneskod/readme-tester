<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\PHPUnit;

class ReadmeTestCase extends \PHPUnit\Framework\TestCase
{
    public function assertReadme(string $filename)
    {
        (new AssertReadme($this))->assertReadme($filename);
    }
}
