<?php

namespace UIIGateway\Castle\Notifications\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublishAndBroadcast;

class PubcastNotificationCreated implements ShouldPublishAndBroadcast
{
    use Queueable;
    use SerializesModels;

    /**
     * The notifiable entity who received the notification.
     *
     * @var mixed
     */
    public $notifiable;

    /**
     * The notification instance.
     *
     * @var \Illuminate\Notifications\Notification
     */
    public $notification;

    /**
     * The notification data.
     *
     * @var array
     */
    public $data = [];

    /**
     * The topic that event should published on.
     *
     * @var string
     */
    public $topic;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @param  array  $data
     * @return void
     */
    public function __construct($notifiable, $notification, $data)
    {
        $this->data = $data;
        $this->notifiable = $notifiable;
        $this->notification = $notification;
        $this->topic = data_get($notification, 'topic');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [new PrivateChannel($this->channelName())];
    }

    /**
     * Get the broadcast channel name for the event.
     *
     * @return string
     */
    protected function channelName(): string
    {
        if (method_exists($this->notifiable, 'receivesBroadcastNotificationsOn')) {
            return $this->notifiable->receivesBroadcastNotificationsOn($this->notification);
        }

        $class = str_replace('\\', '.', get_class($this->notifiable));

        return $class . '.' . $this->notifiable->getKey();
    }

    /**
     * Get the data that should be sent with the broadcasted event.
     *
     * @return array
     */
    public function publishWith()
    {
        $data = [];

        if (method_exists($this->notification, 'publishWith')) {
            $data = $this->notification->publishWith();
        }

        // We only need to check value from 'publishWith'.
        if (Arr::hasAny($data, ['id', 'type', 'topic'])) {
            throw new InvalidArgumentException(
                "Notification 'publishWith' cannot contains 'id', 'type' or 'topic', 
                since it's preserved keys."
            );
        }

        $data = array_merge($this->data, $data, [
            'topic' => $this->topic,
            'id' => $this->notification->id,
            'type' => $this->broadcastType(),
        ]);

        foreach (['publisherScope', 'publisher', 'publishedAt'] as $item) {
            if (blank(Arr::get($data, $item))) {
                throw new InvalidArgumentException(
                    "Notification should contains '{$item}'."
                );
            }
        }

        return $data;
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return method_exists($this->notification, 'broadcastType')
            ? $this->notification->broadcastType()
            : class_basename($this->notification);
    }

    /**
     * Get the event publish name.
     *
     * @return string
     */
    public function publishAs()
    {
        return class_basename($this);
    }

    /**
     * Determine whether the notification should be publish now.
     *
     * @return bool
     */
    public function shouldPublishNow()
    {
        return method_exists($this->notification, 'shouldPublishNow')
            ? $this->notification->shouldPublishNow()
            : false;
    }
}
