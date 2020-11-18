<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event\Listener;

use Crell\Tukio\OrderedProviderInterface;

final class VoidOutputtingSubscriber implements SubscriberInterface
{
    public function registerWith(OrderedProviderInterface $listenerProvider): void
    {
    }
}
