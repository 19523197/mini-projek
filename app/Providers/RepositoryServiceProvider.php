<?php

namespace App\Providers;

use App\Repositories\Contracts\ExampleRepositoryContract;
use App\Repositories\ExampleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ExampleRepositoryContract::class,
            ExampleRepository::class
        );
    }

    public function boot()
    {
        //
    }
}
