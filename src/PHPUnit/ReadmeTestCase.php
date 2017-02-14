<?php

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

    public function assertReadme($filename)
    {
        return $this->asserter->assertReadme($filename);
    }
}
