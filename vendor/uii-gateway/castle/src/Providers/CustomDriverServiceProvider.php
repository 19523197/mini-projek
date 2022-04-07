<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Lumen\Application;
use UIIGateway\Castle\Broadcasting\KafkaBroadcaster;
use UIIGateway\Castle\Notifications\KafkaBroadcastChannel;

class CustomDriverServiceProvider extends BaseServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (class_exists('Junges\Kafka\Kafka')) {
            $this->app->singleton(\Junges\Kafka\Kafka::class, function () {
                return new \Junges\Kafka\Kafka;
            });

            $this->app->alias(
                \Junges\Kafka\Kafka::class,
                \Junges\Kafka\Contracts\CanPublishMessagesToKafka::class
            );

            Broadcast::extend('kafka', function (Application $app) {
                return $app->make(KafkaBroadcaster::class);
            });
        }

        Notification::extend('kafka_broadcast', function (Application $app) {
            return $app->make(KafkaBroadcastChannel::class);
        });
    }
}
