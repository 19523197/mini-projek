<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UIIGateway\Castle\Repositories\Impl\OrganizationRepositoryMysql;
use UIIGateway\Castle\Repositories\OrganizationRepository;

class RepositoryServiceProvider extends BaseServiceProvider
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
        $this->app->bind(OrganizationRepository::class, OrganizationRepositoryMysql::class);
    }
}
