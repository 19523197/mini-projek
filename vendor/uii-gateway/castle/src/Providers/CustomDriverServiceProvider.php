<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Lumen\Application;
use UIIGateway\Castle\Events\Dispatcher;
use UIIGateway\Castle\Notifications\PubcastChannel;

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
        }

        Notification::extend('pubcast', function (Application $app) {
            return $app->make(PubcastChannel::class);
        });

        $this->app->singleton('events', function ($app) {
            return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
                return $app->make(QueueFactoryContract::class);
            });
        });
    }
}
