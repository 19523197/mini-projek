<?php

namespace UIIGateway\Castle\Tests;

use Carbon\Carbon;
use Illuminate\Broadcasting\PrivateChannel;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use UIIGateway\Castle\Publishing\Contracts\Factory as FactoryContract;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublishAndBroadcastNow;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublishNow;
use UIIGateway\Castle\Publishing\Publishers\KafkaPublisher;

class PublishingTest extends TestCase
{
    public function testPublishEventToKafka()
    {
        Kafka::fake();

        config(['publishing.default' => 'kafka']);

        $publishedAt = Carbon::now()->toDateTimeString();

        $event = new DummyPublishEvent;
        $event->publishedAt = $publishedAt;

        event($event);

        Kafka::assertPublishedOn('test', new Message(
            body: [
                'event' => 'DummyPublishEvent',
                'channels' => [],
                'payload' => [
                    'publisherScope' => env('APP_SCOPE_NAME', ''),
                    'publisher' => config('app.name'),
                    'publishedAt' => $publishedAt,
                ],
            ],
        ));
    }

    public function testPublishAndBroadcastEventToKafka()
    {
        Kafka::fake();

        config(['publishing.default' => 'kafka']);

        $publishedAt = Carbon::now()->toDateTimeString();

        $event = new DummyPublishAndBroadcastEvent;
        $event->publishedAt = $publishedAt;

        event($event);

        Kafka::assertPublishedOn('test', new Message(
            body: [
                'event' => 'DummyPublishAndBroadcastEvent',
                'channels' => ['private-dummy'],
                'payload' => [
                    'publisherScope' => env('APP_SCOPE_NAME', ''),
                    'publisher' => config('app.name'),
                    'publishedAt' => $publishedAt,
                ],
            ],
        ));
    }

    public function testKafkaPublishingSetupProperly()
    {
        /** @var \UIIGateway\Castle\Publishing\Publishers\KafkaPublisher $publisher */
        $publisher = app(FactoryContract::class)->driver('kafka');

        $this->assertTrue($publisher instanceof KafkaPublisher);
    }
}

class DummyPublishEvent extends \UIIGateway\Castle\Base\Event implements ShouldPublishNow
{
    public $topic = 'test';
}

class DummyPublishAndBroadcastEvent extends \UIIGateway\Castle\Base\Event implements ShouldPublishAndBroadcastNow
{
    public $topic = 'test';

    public function broadcastOn()
    {
        return new PrivateChannel('dummy');
    }
}
