<?php

namespace UIIGateway\Castle\Broadcasting;

use Exception;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Broadcasting\Broadcasters\UsePusherChannelConventions;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Junges\Kafka\Contracts\CanPublishMessagesToKafka;
use Junges\Kafka\Message\Message;

class KafkaBroadcaster extends Broadcaster
{
    use UsePusherChannelConventions;

    /**
     * The Kafka client instance.
     *
     * @var \Junges\Kafka\Contracts\CanPublishMessagesToKafka
     */
    protected CanPublishMessagesToKafka $kafka;

    /**
     * Create a new broadcaster instance.
     *
     * @param  \Junges\Kafka\Contracts\CanPublishMessagesToKafka  $kafka
     * @return void
     */
    public function __construct(CanPublishMessagesToKafka $kafka)
    {
        $this->kafka = $kafka;
    }

    /**
     * Authenticate the incoming request for a given channel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     *
     * @throws \Exception
     */
    public function auth($request)
    {
        throw new Exception('Not implemented!');
    }

    /**
     * Return the valid authentication response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $result
     * @return mixed
     *
     * @throws \Exception
     */
    public function validAuthenticationResponse($request, $result)
    {
        throw new Exception('Not implemented!');
    }

    /**
     * Broadcast the given event.
     *
     * @param  array  $channels
     * @param  string  $event
     * @param  array  $payload
     * @return void
     *
     * @throws \Illuminate\Broadcasting\BroadcastException
     */
    public function broadcast(array $channels, $event, array $payload = [])
    {
        $socket = Arr::pull($payload, 'socket');
        $topic = Arr::pull($payload, 'topic');

        $body = [
            'channels' => $this->formatChannels($channels),
            'event' => $event,
            'payload' => $payload,
        ];

        if (! is_null($socket)) {
            $body['socket_id'] = $socket;
        }

        if (blank($topic)) {
            throw new InvalidArgumentException(
                'Topic is required to use Kafka Broadcaster. ' .
                'You must specify topic in your event.'
            );
        }

        $message = new Message(
            body: $body,
        );

        $publisher = $this->kafka->publishOn($topic)
            ->withMessage($message);

        try {
            $publisher->send();
        } catch (Exception $e) {
            throw new BroadcastException(
                sprintf('Kafka error: %s.', $e->getMessage())
            );
        }
    }

    /**
     * Get the Kafka client instance.
     *
     * @return \Junges\Kafka\Contracts\CanPublishMessagesToKafka
     */
    public function getKafka()
    {
        return $this->kafka;
    }

    /**
     * Set the Kafka client instance.
     *
     * @param  \Junges\Kafka\Contracts\CanPublishMessagesToKafka  $kafka
     * @return $this
     */
    public function setKafka(CanPublishMessagesToKafka $kafka)
    {
        $this->kafka = $kafka;

        return $this;
    }
}
