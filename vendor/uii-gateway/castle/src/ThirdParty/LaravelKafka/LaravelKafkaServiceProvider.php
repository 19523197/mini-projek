<?php

namespace UIIGateway\Castle\ThirdParty\LaravelKafka;

use Junges\Kafka\Console\Commands\KafkaConsumerCommand;
use Junges\Kafka\Providers\LaravelKafkaServiceProvider as ServiceProvider;

class LaravelKafkaServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    public function boot(): void
    {
        $this->publishesConfiguration();

        if ($this->app->runningInConsole()) {
            $this->commands([
                KafkaConsumerCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->configure('kafka');
        $this->mergeConfigFrom(__DIR__ . '/../../../config/kafka.php', 'kafka');

        parent::register();
    }

    protected function publishesConfiguration()
    {
        $this->publishes([
            __DIR__ . '/../../../config/kafka.php' => $this->configPath('kafka.php'),
        ], 'laravel-kafka-config');
    }

    protected function configPath($path)
    {
        return app()->basePath() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $path;
    }
}
