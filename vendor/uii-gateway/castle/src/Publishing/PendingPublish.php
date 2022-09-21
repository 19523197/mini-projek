<?php

namespace UIIGateway\Castle\Publishing;

use Illuminate\Contracts\Events\Dispatcher;

class PendingPublish
{
    /**
     * The event dispatcher implementation.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The event instance.
     *
     * @var mixed
     */
    protected $event;

    /**
     * Create a new pending publish instance.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @param  mixed  $event
     * @return void
     */
    public function __construct(Dispatcher $events, $event)
    {
        $this->event = $event;
        $this->events = $events;
    }

    /**
     * Publish the event using a specific publisher.
     *
     * @param  string|null  $connection
     * @return $this
     */
    public function via($connection = null)
    {
        if (method_exists($this->event, 'publishVia')) {
            $this->event->publishVia($connection);
        }

        return $this;
    }

    /**
     * Handle the object's destruction.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->events->dispatch($this->event);
    }
}
