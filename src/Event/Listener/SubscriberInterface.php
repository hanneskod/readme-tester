<?php

namespace hanneskod\readmetester\Event\Listener;

use Crell\Tukio\OrderedProviderInterface;

interface SubscriberInterface
{
    public function registerWith(OrderedProviderInterface $listenerProvider): void;
}
