<?php

namespace UIIGateway\Castle;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UIIGateway\Castle\Auth\OrganizationAuth;
use UIIGateway\Castle\Http\FormRequest;
use UIIGateway\Castle\Providers\MacroServiceProvider;
use UIIGateway\Castle\Providers\MiddlewareServiceProvider;
use UIIGateway\Castle\Providers\RepositoryServiceProvider;
use UIIGateway\Castle\Repositories\OrganizationRepository;
use UIIGateway\Castle\Utility\ReflectionHelper;

class ServiceProvider extends BaseServiceProvider
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
        if (! $this->app->environment('testing')) {
            ini_set('display_errors', 'Off');
        }

        $this->app->configure('castle');
        $this->mergeConfigFrom(__DIR__ . '/../config/castle.php', 'castle');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'castle');

        $this->mergeConfig('filesystems');

        $this->app->register(MiddlewareServiceProvider::class);

        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
        $this->app->register(\BenSampo\Enum\EnumServiceProvider::class);

        if ($this->app->environment() !== 'production') {
            if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
                $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            }
        }

        $this->mergeConfig('ide-helper');

        $this->app->register(MacroServiceProvider::class);

        $this->registerFacades();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/castle.php' => $this->configPath('castle.php'),
                __DIR__ . '/../config/filesystems.php' => $this->configPath('filesystems.php'),
                __DIR__ . '/../config/ide-helper.php' => $this->configPath('ide-helper.php'),
                __DIR__ . '/../resources/lang' => $this->langPath('vendor/castle'),
            ]);
        }

        $this->registerLocale();
        $this->registerFormRequest();
    }

    protected function registerFacades()
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

    protected function registerLocale()
    {
        $locale = $this->app->getLocale();

        Carbon::setLocale($locale);
        CarbonImmutable::setLocale($locale);
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

    protected function mergeConfig($key)
    {
        if (! $this->isConfigLoaded($key) ||
            ($this->isConfigLoaded($key) && ! file_exists($this->configPath($key . '.php')))
        ) {
            $config = $this->app->make('config');

            $config->set($key, $this->mergeDeep(
                $config->get($key, []),
                require __DIR__ . "/../config/$key.php"
            ));
        }
    }

    protected function isConfigLoaded($key)
    {
        return Arr::get(
            ReflectionHelper::getRestrictedProperty($this->app, 'loadedConfigurations'),
            $key
        );
    }

    protected function configPath($path)
    {
        return app()->basePath() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $path;
    }

    protected function langPath($path)
    {
        return app()->basePath() . DIRECTORY_SEPARATOR .
            'resources' . DIRECTORY_SEPARATOR .
            'lang' . DIRECTORY_SEPARATOR .
            $path;
    }

    protected function mergeDeep(...$args)
    {
        $result = [];

        foreach ($args as $array) {
            foreach (Arr::wrap($array) as $key => $value) {
                if (is_integer($key)) {
                    $result[] = $value;
                } elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                    $result[$key] = $this->mergeDeep($result[$key], $value);
                } else {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }
}
