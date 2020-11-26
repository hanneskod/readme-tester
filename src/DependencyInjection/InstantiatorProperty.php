<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\DependencyInjection;

use hanneskod\readmetester\Utils\Instantiator;

/**
 * Use this trait to automatically inject an instantiator
 */
trait InstantiatorProperty
{
    protected Instantiator $instantiator;

    /**
     * @required
     */
    public function setInstantiator(Instantiator $instantiator): void
    {
        $this->instantiator = $instantiator;
    }
}
