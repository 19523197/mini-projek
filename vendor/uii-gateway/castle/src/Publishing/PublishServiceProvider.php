<?php

namespace UIIGateway\Castle\Publishing;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use UIIGateway\Castle\Publishing\Contracts\Factory as PublishingFactory;
use UIIGateway\Castle\Publishing\Publishers\Publisher as PublisherContract;

class PublishServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('publishing');

        $this->app->singleton(PublishManager::class, function ($app) {
            return new PublishManager($app);
        });

        $this->app->singleton(PublisherContract::class, function ($app) {
            return $app->make(PublishManager::class)->connection();
        });

        $this->app->alias(
            PublishManager::class, PublishingFactory::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            PublishManager::class,
            PublishingFactory::class,
            PublisherContract::class,
        ];
    }
}
