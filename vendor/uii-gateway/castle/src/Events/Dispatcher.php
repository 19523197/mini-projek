<?php

namespace UIIGateway\Castle\Events;

use Illuminate\Events\Dispatcher as BaseDispatcher;
use UIIGateway\Castle\Publishing\Contracts\Factory as PublishFactory;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublish;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublishAndBroadcast;

class Dispatcher extends BaseDispatcher
{
    /**
     * Fire an event and call the listeners.
     *
     * @param  string|object  $event
     * @param  mixed  $payload
     * @param  bool  $halt
     * @return array|null
     */
    public function dispatch($event, $payload = [], $halt = false)
    {
        [$event, $payload] = $this->parseEventAndPayload(
            $event, $payload
        );

        if ($this->shouldPublish($payload)) {
            $this->publishEvent($payload[0]);
        }

        return parent::dispatch($event, $payload, $halt);
    }

    /**
     * Determine if the payload has a publishable event.
     *
     * @param  array  $payload
     * @return bool
     */
    protected function shouldPublish(array $payload)
    {
        return isset($payload[0]) &&
            (
                $payload[0] instanceof ShouldPublish ||
                $payload[0] instanceof ShouldPublishAndBroadcast
            ) &&
            $this->publishWhen($payload[0]);
    }

    /**
     * Check if the event should be published by the condition.
     *
     * @param  mixed  $event
     * @return bool
     */
    protected function publishWhen($event)
    {
        return method_exists($event, 'publishWhen')
            ? $event->publishWhen()
            : true;
    }

    /**
     * Publish the given event class.
     *
     * @param  \UIIGateway\Castle\Publishing\Contracts\ShouldPublish  $event
     * @return void
     */
    protected function publishEvent($event)
    {
        $this->container->make(PublishFactory::class)->queue($event);
    }
}
