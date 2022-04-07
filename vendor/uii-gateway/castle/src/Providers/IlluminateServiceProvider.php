<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UIIGateway\Castle\Http\FormRequest;

class IlluminateServiceProvider extends BaseServiceProvider
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
        $this->registerNotifications();
        $this->registerMailer();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerFormRequest();
    }

    protected function registerFormRequest()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(FormRequest::class, function ($request, $app) {
            $request = FormRequest::createFrom($app['request'], $request);

            $request->setContainer($app);
        });
    }

    protected function registerNotifications()
    {
        $this->app->register(\Illuminate\Notifications\NotificationServiceProvider::class);

        if (! class_exists('Notification')) {
            class_alias(\Illuminate\Support\Facades\Notification::class, 'Notification');
        }
    }

    protected function registerMailer()
    {
        $this->app->register(\Illuminate\Mail\MailServiceProvider::class);

        $this->app->alias('mail.manager', \Illuminate\Mail\MailManager::class);
        $this->app->alias('mail.manager', \Illuminate\Contracts\Mail\Factory::class);
        $this->app->alias('mailer', \Illuminate\Mail\Mailer::class);
        $this->app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);
        $this->app->alias('mailer', \Illuminate\Contracts\Mail\MailQueue::class);

        if (! class_exists('Mail')) {
            class_alias(\Illuminate\Support\Facades\Mail::class, 'Mail');
        }
    }
}
