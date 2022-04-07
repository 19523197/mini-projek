<?php

namespace UIIGateway\Castle\Base;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;

abstract class Notification extends BaseNotification
{
    use Queueable;

    public string $topic = 'websocket-notification';

    public string $publisherScope;

    public string $publisher;

    public string $publishedAt;

    public function __construct()
    {
        $this->publisherScope = env('APP_SCOPE_NAME', '');
        $this->publisher = config('app.name', '');
        $this->publishedAt = Carbon::now()->toDateTimeString();
    }

    final public function broadcastWith()
    {
        return [
            'publisherScope' => $this->publisherScope,
            'publisher' => $this->publisher,
            'publishedAt' => $this->publishedAt,
        ];
    }

    final public function broadcastOn()
    {
        return [];
    }

    abstract public function via($notifiable);
}
