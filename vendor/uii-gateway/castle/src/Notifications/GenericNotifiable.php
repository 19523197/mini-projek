<?php

namespace UIIGateway\Castle\Notifications;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

class GenericNotifiable extends AnonymousNotifiable
{
    protected string $notifiableName;

    protected string $notifiableId;

    public function __construct(string $notifiableName, string $notifiableId)
    {
        $this->notifiableName = $notifiableName;
        $this->notifiableId = $notifiableId;
    }

    public static function make(string $notifiableName, string $notifiableId)
    {
        return new static($notifiableName, $notifiableId);
    }

    public function receivesBroadcastNotificationsOn(Notification $notification)
    {
        return $this->notifiableName . '.' . $this->getKey();
    }

    public function getKey(): string
    {
        return $this->notifiableId;
    }
}
