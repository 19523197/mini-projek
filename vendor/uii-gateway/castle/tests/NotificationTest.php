<?php

namespace UIIGateway\Castle\Tests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Junges\Kafka\Message\Message;
use UIIGateway\Castle\Notifications\GenericNotifiable;
use UIIGateway\Castle\ThirdParty\LaravelKafka\Facades\Kafka;

class NotificationTest extends TestCase
{
    public function testNotificationViaKafka()
    {
        Kafka::fake();

        config(['broadcasting.default' => 'kafka']);

        $notifiable = GenericNotifiable::make('user', 1);
        $notification = new DummyNotification;

        $notifiable->notify($notification);

        $message = new Message(
            body: [
                'channels' => ['private-' . $notifiable->receivesBroadcastNotificationsOn($notification)],
                'event' => 'BroadcastNotificationCreated',
                'payload' => [
                    'publisherScope' => env('APP_SCOPE_NAME', ''),
                    'publisher' => config('app.name'),
                    'publishedAt' => Carbon::now()->toDateTimeString(),
                    'type' => DummyNotification::class,
                ],
            ],
        );

        Kafka::assertPublishedOn(
            'websocket-notification',
            $message,
            function (Message $publishedMessage, Message $expectedMessage) {
                $data = $publishedMessage->toArray();
                Arr::forget($data, ['payload.payload.id']);

                return $data === $expectedMessage->toArray();
            }
        );
    }
}

class DummyNotification extends \UIIGateway\Castle\Base\Notification
{
    public function via($notifiable)
    {
        return 'kafka_broadcast';
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
