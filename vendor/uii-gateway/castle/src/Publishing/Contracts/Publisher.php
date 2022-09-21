<?php

namespace UIIGateway\Castle\Publishing\Contracts;

interface Publisher
{
    /**
     * Publish the given event to the messaging service.
     *
     * @param  string  $event
     * @param  array  $payload
     * @param  array  $channels
     * @return void
     */
    public function publish($event, array $payload = [], array $channels = []);
}
