<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Event\Listener;

use hanneskod\readmetester\Event\Listener\SubscriberFactory;
use hanneskod\readmetester\Event\Listener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubscriberFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SubscriberFactory::class);
    }

    function it_creates_debug_subscriber()
    {
        $this->createSubscriber(SubscriberFactory::SUBSCRIBER_DEBUG)
            ->shouldHaveType(Listener\DebugOutputtingSubscriber::class);
    }

    function it_creates_default_subscriber()
    {
        $this->createSubscriber(SubscriberFactory::SUBSCRIBER_DEFAULT)
            ->shouldHaveType(Listener\DefaultOutputtingSubscriber::class);
    }

    function it_creates_json_subscriber()
    {
        $this->createSubscriber(SubscriberFactory::SUBSCRIBER_JSON)
            ->shouldHaveType(Listener\JsonOutputtingSubscriber::class);
    }

    function it_creates_void_subscriber()
    {
        $this->createSubscriber(SubscriberFactory::SUBSCRIBER_VOID)
            ->shouldHaveType(Listener\VoidOutputtingSubscriber::class);
    }
}
