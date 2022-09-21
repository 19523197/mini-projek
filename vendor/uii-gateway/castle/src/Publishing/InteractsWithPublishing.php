<?php

namespace UIIGateway\Castle\Publishing;

use Illuminate\Support\Arr;

trait InteractsWithPublishing
{
    /**
     * The publisher connection to use to publish the event.
     *
     * @var array
     */
    protected $publishConnection = [null];

    /**
     * Publish the event using a specific publisher.
     *
     * @param  array|string|null  $connection
     * @return $this
     */
    public function publishVia($connection = null)
    {
        $this->publishConnection = is_null($connection)
            ? [null]
            : Arr::wrap($connection);

        return $this;
    }

    /**
     * Get the publisher connections the event should be publish on.
     *
     * @return array
     */
    public function publishConnections()
    {
        return $this->publishConnection;
    }
}
