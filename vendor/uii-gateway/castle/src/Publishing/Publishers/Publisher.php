<?php

namespace UIIGateway\Castle\Publishing\Publishers;

use UIIGateway\Castle\Publishing\Contracts\Publisher as PublisherContract;

abstract class Publisher implements PublisherContract
{
    /**
     * Format the channel array into an array of strings.
     *
     * @param  array  $channels
     * @return array
     */
    protected function formatChannels(array $channels)
    {
        return array_map(function ($channel) {
            return (string) $channel;
        }, $channels);
    }
}
