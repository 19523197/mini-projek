<?php

namespace UIIGateway\Castle\Tests;

use Carbon\Carbon;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Broadcast;
use Junges\Kafka\Message\Message;
use UIIGateway\Castle\Broadcasting\KafkaBroadcaster;
use UIIGateway\Castle\ThirdParty\LaravelKafka\Facades\Kafka;

class KafkaTest extends TestCase
{
    public function testBroadcastEventToKafka()
    {
        Kafka::fake();

        config(['broadcasting.default' => 'kafka']);

        broadcast(new DummyEvent);

        Kafka::assertPublishedOn('test', new Message(
            body: [
                'channels' => ['private-dummy'],
                'event' => DummyEvent::class,
                'payload' => [
                    'requestHeaders' => [],
                    'publisherScope' => env('APP_SCOPE_NAME', ''),
                    'publisher' => config('app.name'),
                    'publishedAt' => Carbon::now()->toDateTimeString(),
                ],
            ],
        ));
    }

    public function testBroadcastEventToSpecificKafkaTopic()
    {
        Kafka::fake();

        config(['broadcasting.default' => 'kafka']);

        $kafkaTopic = 'ABC';

        $event = (new DummyEvent);
        $event->topic = $kafkaTopic;

        broadcast($event);

        $message = new Message(
            body: [
                'channels' => ['private-dummy'],
                'event' => DummyEvent::class,
                'payload' => [
                    'requestHeaders' => [],
                    'publisherScope' => env('APP_SCOPE_NAME', ''),
                    'publisher' => config('app.name'),
                    'publishedAt' => Carbon::now()->toDateTimeString(),
                ],
            ],
        );

        Kafka::assertPublishedOn($kafkaTopic, $message);
    }

    public function testKafkaBroadcastingSetupProperly()
    {
        /** @var \UIIGateway\Castle\Broadcasting\KafkaBroadcaster $broadcaster */
        $broadcaster = Broadcast::getFacadeRoot()->driver('kafka');

        $this->assertTrue($broadcaster instanceof KafkaBroadcaster);
    }
}

class DummyEvent extends \UIIGateway\Castle\Base\Event implements ShouldBroadcastNow
{
    public $topic = 'test';

    public function broadcastOn()
    {
        return new PrivateChannel('dummy');
    }
}
