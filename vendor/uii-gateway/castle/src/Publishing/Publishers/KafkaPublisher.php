<?php

namespace UIIGateway\Castle\Publishing\Publishers;

use Exception;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Junges\Kafka\Contracts\CanProduceMessages;
use Junges\Kafka\Message\Message;
use UIIGateway\Castle\Publishing\PublishException;
use UIIGateway\Castle\Utility\ReflectionHelper;

class KafkaPublisher extends Publisher
{
    /**
     * The Kafka producer client instance.
     *
     * @var \Junges\Kafka\Contracts\CanProduceMessages
     */
    protected CanProduceMessages $kafkaProducer;

    /**
     * Create a new publisher instance.
     *
     * @param  \Junges\Kafka\Contracts\CanProduceMessages  $kafka
     * @return void
     */
    public function __construct(CanProduceMessages $kafka)
    {
        $this->kafkaProducer = $kafka;
    }

    /**
     * {@inheritdoc}
     */
    public function publish($event, array $payload = [], array $channels = [])
    {
        $topic = Arr::pull($payload, 'topic');

        $body = [
            'event' => $event,
            'channels' => $this->formatChannels($channels),
            'payload' => $payload,
        ];

        if (blank($topic)) {
            throw new InvalidArgumentException(
                'Topic is required to use Kafka Publisher. ' .
                'You must specify topic in your event.'
            );
        }

        $message = new Message(
            topicName: $topic,
            body: $body,
        );

        $publisher = $this->kafkaProducer
            ->withMessage($message);

        // hacky
        ReflectionHelper::setRestrictedProperty($publisher, 'topic', $topic);

        try {
            $publisher->send();
        } catch (Exception $e) {
            throw new PublishException(
                sprintf('Kafka error: %s.', $e->getMessage())
            );
        }
    }

    /**
     * Get the Kafka producer client instance.
     *
     * @return \Junges\Kafka\Contracts\CanProduceMessages
     */
    public function getKafkaProducer()
    {
        return $this->kafkaProducer;
    }

    /**
     * Set the Kafka producer client instance.
     *
     * @param  \Junges\Kafka\Contracts\CanProduceMessages  $kafkaProducer
     * @return $this
     */
    public function setKafkaProducer(CanProduceMessages $kafkaProducer)
    {
        $this->kafkaProducer = $kafkaProducer;

        return $this;
    }
}
