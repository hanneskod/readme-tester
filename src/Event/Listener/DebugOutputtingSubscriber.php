<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event\Listener;

use hanneskod\readmetester\Event;
use hanneskod\readmetester\Console;
use Crell\Tukio\OrderedProviderInterface;

final class DebugOutputtingSubscriber implements SubscriberInterface, Console\OutputAwareInterface
{
    use Console\OutputAwareTrait;

    public function registerWith(OrderedProviderInterface $listenerProvider): void
    {
        $listenerProvider->addListener([$this, 'onDebugEvent']);
    }

    public function onDebugEvent(Event\DebugEvent $event): void
    {
        $this->getOutput()->writeln($event->getMessage());
    }
}
