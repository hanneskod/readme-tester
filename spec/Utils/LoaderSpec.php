<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Utils;

use hanneskod\readmetester\Utils\Loader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Loader::class);
    }

    function it_loades_code()
    {
        $this->load("class it_loades_code {}");

        // this will fail if code is not loaded
        new \it_loades_code;
    }

    function it_returnes_what_loaded_code_returns()
    {
        $this->load("return 'foobar';")->shouldReturn('foobar');
    }

    function it_loades_once()
    {
        $this->loadOnce("class it_loades_once {}");

        // this will fail if code is not loaded
        new \it_loades_once;

        // will fail if code is loaded twice
        $this->loadOnce("class it_loades_once {}");
    }
}
