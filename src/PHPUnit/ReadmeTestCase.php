<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\PHPUnit;

class ReadmeTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var AssertReadme
     */
    private $asserter;

    public function __construct(AssertReadme $asserter = null)
    {
        $this->asserter = $asserter ?: new AssertReadme($this);
    }

    public function assertReadme(string $filename)
    {
        $this->asserter->assertReadme($filename);
    }
}
