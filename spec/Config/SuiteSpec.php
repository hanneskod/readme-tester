<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Config;

use hanneskod\readmetester\Config\Suite;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SuiteSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(Suite::class);
    }

    function it_contains_values()
    {
        $this->beConstructedWith(
            'name',
            false,
            'inputLanguage',
            'runner',
            ['includePaths'],
            ['excludePaths'],
            ['fileExtensions'],
            ['globalAttributes'],
            true,
            'filter',
            true,
        );

        $this->getSuiteName()->shouldReturn('name');
        $this->isActive()->shouldReturn(false);
        $this->getInputLanguage()->shouldReturn('inputLanguage');
        $this->getRunner()->shouldReturn('runner');
        $this->getIncludePaths()->shouldReturn(['includePaths']);
        $this->getExcludePaths()->shouldReturn(['excludePaths']);
        $this->getFileExtensions()->shouldReturn(['fileExtensions']);
        $this->getFilter()->shouldReturn('filter');
        $this->getGlobalAttributes()->shouldReturn(['globalAttributes']);
        $this->stopOnFailure()->shouldReturn(true);
        $this->readFromStdin()->shouldReturn(true);
    }
}
