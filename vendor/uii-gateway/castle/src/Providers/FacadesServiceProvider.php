<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UIIGateway\Castle\Auth\OrganizationAuth;
use UIIGateway\Castle\Repositories\OrganizationRepository;

class FacadesServiceProvider extends BaseServiceProvider
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
    }
}
