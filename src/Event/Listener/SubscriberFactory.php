<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event\Listener;

final class SubscriberFactory
{
    const SUBSCRIBER_DEBUG = 'debug';
    const SUBSCRIBER_DEFAULT = 'default';
    const SUBSCRIBER_JSON = 'json';
    const SUBSCRIBER_VOID = 'void';

    public function createSubscriber(string $id): SubscriberInterface
    {
        switch (true) {
            case $id == self::SUBSCRIBER_DEBUG:
                return new DebugOutputtingSubscriber;
            case $id == self::SUBSCRIBER_DEFAULT:
                return new DefaultOutputtingSubscriber;
            case $id == self::SUBSCRIBER_JSON:
                return new JsonOutputtingSubscriber;
            case $id == self::SUBSCRIBER_VOID:
                return new VoidOutputtingSubscriber;
        }

        // TODO create from classname

        throw new \RuntimeException("Unknown subscriber: $id");
    }
}
