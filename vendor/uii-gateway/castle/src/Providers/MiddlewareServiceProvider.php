<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Support\ServiceProvider;
use UIIGateway\Castle\Http\Middleware\Localization;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->middleware([
            Localization::class,
        ]);
    }
}
