<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\SourceFileIterator;
use hanneskod\readmetester\Engine;
use hanneskod\readmetester\Runner\RunnerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SourceFileIteratorSpec extends ObjectBehavior
{
    const PROJECT_ROOT = __DIR__ . '/..';

    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(SourceFileIterator::class);
    }

    function it_finds_single_file()
    {
        $this->beConstructedWith(self::PROJECT_ROOT . '/README.md');
        $this->getIterator()->shouldHaveCount(1);
    }

    function it_finds_content()
    {
        $fname = self::PROJECT_ROOT . '/README.md';
        $this->beConstructedWith($fname);
        $this->getIterator()->shouldIterateAs([$fname => file_get_contents($fname)]);
    }
}
