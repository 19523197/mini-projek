<?php

namespace UIIGateway\Castle\ThirdParty\LaravelKafka\Facades;

use Illuminate\Support\Facades\Facade;
use Junges\Kafka\Contracts\KafkaProducerMessage;
use UIIGateway\Castle\ThirdParty\LaravelKafka\KafkaFake;

/**
 * @formatter:off
 * // phpcs:disable Generic.Files.LineLength.MaxExceeded
 * @method static \Junges\Kafka\Contracts\CanProduceMessages publishOn(string $topic, string $broker = null)
 * @method static \Junges\Kafka\Consumers\ConsumerBuilder createConsumer(array $topics = [], string $groupId = null, string $brokers = null)
 * @method static void assertPublished(KafkaProducerMessage $expectedMessage = null, callable $callback = null)
 * @method static void assertPublishedTimes(int $times = 1, KafkaProducerMessage $expectedMessage = null, callable $callback = null)
 * @method static void assertPublishedOn(string $topic, KafkaProducerMessage $expectedMessage = null, callable $callback = null)
 * @method static void assertPublishedOnTimes(string $topic, int $times = 1, KafkaProducerMessage $expectedMessage = null, callable $callback = null)
 * @method static void assertNothingPublished()
 * // phpcs:enable
 * @formatter:on
 * @mixin \Junges\Kafka\Kafka
 *
 * @see \Junges\Kafka\Kafka
 */
class Kafka extends Facade
{
    public static function fake(): KafkaFake
    {
        static::swap($fake = new KafkaFake());

        return $fake;
    }

    public static function getFacadeAccessor(): string
    {
        return \Junges\Kafka\Kafka::class;
    }
}
