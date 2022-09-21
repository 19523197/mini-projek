<?php

namespace UIIGateway\Castle\Publishing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionProperty;
use UIIGateway\Castle\Publishing\Contracts\Factory as PublishingFactory;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublishAndBroadcast;

class PublishEvent implements ShouldQueue
{
    use Queueable;

    /**
     * The event instance.
     *
     * @var mixed
     */
    public $event;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout;

    /**
     * Create a new job handler instance.
     *
     * @param  mixed  $event
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
        $this->tries = property_exists($event, 'tries') ? $event->tries : null;
        $this->timeout = property_exists($event, 'timeout') ? $event->timeout : null;
        $this->afterCommit = property_exists($event, 'afterCommit') ? $event->afterCommit : null;
    }

    /**
     * Handle the queued job.
     *
     * @param  \UIIGateway\Castle\Publishing\Contracts\Factory  $manager
     * @return void
     */
    public function handle(PublishingFactory $manager)
    {
        $name = method_exists($this->event, 'publishAs')
            ? $this->event->publishAs()
            : get_class($this->event);

        $channels = [];

        if (
            method_exists($this->event, 'broadcastOn') &&
            $this->event instanceof ShouldPublishAndBroadcast
        ) {
            $channels = Arr::wrap($this->event->broadcastOn());
        }

        $connections = method_exists($this->event, 'publishConnections')
            ? $this->event->publishConnections()
            : [null];

        $payload = $this->getPayloadFromEvent($this->event);

        foreach ($connections as $connection) {
            $manager->connection($connection)->publish(
                $name, $payload, $channels
            );
        }
    }

    /**
     * Get the payload for the given event.
     *
     * @param  mixed  $event
     * @return array
     */
    protected function getPayloadFromEvent($event)
    {
        if (
            method_exists($event, 'publishWith') &&
            ! is_null($payload = $event->publishWith())
        ) {
            return $payload;
        }

        $payload = [];

        foreach ((new ReflectionClass($event))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $payload[$property->getName()] = $this->formatProperty($property->getValue($event));
        }

        unset($payload['publishQueue']);

        return $payload;
    }

    /**
     * Format the given value for a property.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function formatProperty($value)
    {
        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        return $value;
    }

    /**
     * Get the display name for the queued job.
     *
     * @return string
     */
    public function displayName()
    {
        return get_class($this->event);
    }

    /**
     * Prepare the instance for cloning.
     *
     * @return void
     */
    public function __clone()
    {
        $this->event = clone $this->event;
    }
}
