<?php

namespace UIIGateway\Castle\Publishing\Publishers;

class NullPublisher extends Publisher
{
    /**
     * {@inheritdoc}
     */
    public function publish($event, array $payload = [], array $channels = [])
    {
        //
    }
}
