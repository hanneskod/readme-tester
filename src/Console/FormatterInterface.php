<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use hanneskod\readmetester\ListenerInterface;

/**
 * Output formatter interface
 */
interface FormatterInterface extends ListenerInterface
{
    public function onInvokationStart(): void;

    public function onBootstrap(string $filename): void;

    public function onFile(string $filename): void;

    public function onInvokationEnd(): void;
}
