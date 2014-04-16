<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface ExpectationInterface
{
    /**
     * Enter expect mode
     *
     * @return void
     */
    public function start();

    /**
     * Evaluate that the expected condition is met
     *
     * @param  mixed $returnValue Example method return value
     * @return void
     */
    public function evaluate($returnValue);
}
