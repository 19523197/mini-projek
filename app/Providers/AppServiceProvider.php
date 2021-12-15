<?php

namespace App\Providers;

use App\Http\Requests\FormRequest;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        $locale = $this->app->getLocale();
        Carbon::setLocale($locale);
        CarbonImmutable::setLocale($locale);

        $this->app->resolving(FormRequest::class, function ($form, $app) {
            $form = FormRequest::createFrom($app['request'], $form);
            $form->setContainer($app);
        });

        $this->app->afterResolving(FormRequest::class, function (FormRequest $form) {
            $form->validate();
        });
    }
}
