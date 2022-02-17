<?php

namespace UIIGateway\Core;

use Illuminate\Support\ServiceProvider;

class UIIGatewayServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'ApplicationGenerator' => 'command.app.generate',
        'MVPGenerator' => 'command.mvp.generate',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands($this->commands);
    }

    /**
     * Register the given commands.
     *
     * @param array $commands
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $method = "register{$command}Command";

            call_user_func_array([$this, $method], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     */
    protected function registerApplicationGeneratorCommand()
    {
        $this->app->singleton('command.app.generate', function ($app) {
            return new Console\Commands\ApplicationGeneratorCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerMVPGeneratorCommand()
    {
        $this->app->singleton('command.mvp.generate', function ($app) {
            return new Console\Commands\MVPGeneratorCommand($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }
}
