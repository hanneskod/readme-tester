<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Formatter;

use hanneskod\readmetester\ListenerInterface;

/**
 * Output formatter interface
 */
interface FormatterInterface extends ListenerInterface
{
    public function onInvokationStart(): void;

    public function onFile(string $filename): void;

    public function onInvokationEnd(): void;
}
