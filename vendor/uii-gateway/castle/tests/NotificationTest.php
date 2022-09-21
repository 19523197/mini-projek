<?php

namespace UIIGateway\Castle\Tests;

use Carbon\Carbon;
use Illuminate\Contracts\Notifications\Dispatcher as NotificationDispatcher;
use Illuminate\Support\Arr;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use UIIGateway\Castle\Notifications\GenericNotifiable;
use UIIGateway\Castle\Notifications\PubcastChannel;

class NotificationTest extends TestCase
{
    public function testNotificationViaKafka()
    {
        Kafka::fake();

        config(['publishing.default' => 'kafka']);

        $publishedAt = Carbon::now()->toDateTimeString();

        $notifiable = GenericNotifiable::make('user', 1);
        $notification = new DummyNotification;
        $notification->publishedAt = $publishedAt;

        $notifiable->notify($notification);

        $message = new Message(
            body: [
                'event' => 'PubcastNotificationCreated',
                'channels' => ['private-' . $notifiable->receivesBroadcastNotificationsOn($notification)],
                'payload' => [
                    'publisherScope' => env('APP_SCOPE_NAME', ''),
                    'publisher' => config('app.name'),
                    'publishedAt' => $publishedAt,
                    'type' => 'DummyNotification',
                ],
            ],
        );

        Kafka::assertPublishedOn(
            'websocket-notification',
            $message,
            function (Message $publishedMessage) use ($message) {
                $data = $publishedMessage->toArray();
                Arr::forget($data, ['payload.payload.id']);

                return json_encode($data) === json_encode($message->toArray());
            }
        );
    }

    public function testKafkaPubcastChannelSetupProperly()
    {
        /** @var \UIIGateway\Castle\Notifications\PubcastChannel $channel */
        $channel = app(NotificationDispatcher::class)->driver('pubcast');

        $this->assertTrue($channel instanceof PubcastChannel);
    }
}

class DummyNotification extends \UIIGateway\Castle\Base\Notification
{
    public function via($notifiable)
    {
        return 'pubcast';
    }

    public function toArray($notifiable)
    {
        return [];
    }

    public function shouldPublishNow()
    {
        return true;
    }
}
