<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UIIGateway\Castle\Console\VendorPublishCommand;
use UIIGateway\Castle\Console\ViewKafkaTopicRecordsCommand;

class CommandServiceProvider extends BaseServiceProvider implements DeferrableProvider
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
        $this->commands([
            VendorPublishCommand::class,
        ]);

        if (class_exists('RdKafka')) {
            $this->commands([
                ViewKafkaTopicRecordsCommand::class,
            ]);
        }
    }
}
