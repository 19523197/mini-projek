<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UIIGateway\Castle\Auth\Auth;
use UIIGateway\Castle\Auth\OrganizationAuth;
use UIIGateway\Castle\Repositories\OrganizationRepository;

class FacadesServiceProvider extends BaseServiceProvider implements DeferrableProvider
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
        $this->app->singleton(OrganizationAuth::class, function (Container $app) {
            $organizations = array_filter(
                explode(';', request()->header('x-organization', '')),
                fn ($item) => $item
            );

            return new OrganizationAuth(
                $app->make(OrganizationRepository::class),
                $organizations
            );
        });

        $this->app->singleton(Auth::class, function (Container $app) {
            return new Auth($app->make('request'));
        });
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [
            OrganizationAuth::class,
            Auth::class,
        ];
    }
}
