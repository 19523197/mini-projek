<?php

namespace UIIGateway\Castle;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UIIGateway\Castle\Providers\CustomDriverServiceProvider;
use UIIGateway\Castle\Providers\FacadesServiceProvider;
use UIIGateway\Castle\Providers\IlluminateServiceProvider;
use UIIGateway\Castle\Providers\MacroServiceProvider;
use UIIGateway\Castle\Providers\MiddlewareServiceProvider;
use UIIGateway\Castle\Providers\MiscServiceProvider;
use UIIGateway\Castle\Providers\RepositoryServiceProvider;
use UIIGateway\Castle\ThirdParty\LaravelKafka\LaravelKafkaServiceProvider;
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
        $this->initRegister();
        $this->app->register(IlluminateServiceProvider::class);

        $this->app->configure('castle');
        $this->mergeConfigFrom(__DIR__ . '/../config/castle.php', 'castle');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'castle');

        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
        $this->app->register(\BenSampo\Enum\EnumServiceProvider::class);

        if (class_exists('Junges\Kafka\Providers\LaravelKafkaServiceProvider')) {
            $this->app->register(LaravelKafkaServiceProvider::class);
        }

        if ($this->app->environment() !== 'production') {
            if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
                $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            }
        }

        $this->app->register(MacroServiceProvider::class);
        $this->app->register(FacadesServiceProvider::class);
        $this->app->register(CustomDriverServiceProvider::class);
        $this->app->register(MiscServiceProvider::class);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfig('filesystems');
        $this->mergeConfig('mail');
        $this->mergeConfig('services');
        $this->mergeConfig('ide-helper');

        if (class_exists('Junges\Kafka\Providers\LaravelKafkaServiceProvider')) {
            $this->mergeConfig('broadcasting', [
                'connections' => [
                    'kafka' => [
                        'driver' => 'kafka',
                    ],
                ],
            ]);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/castle.php' => $this->configPath('castle.php'),
                __DIR__ . '/../config/filesystems.php' => $this->configPath('filesystems.php'),
                __DIR__ . '/../config/mail.php' => $this->configPath('mail.php'),
                __DIR__ . '/../config/services.php' => $this->configPath('services.php'),
                __DIR__ . '/../config/ide-helper.php' => $this->configPath('ide-helper.php'),
                __DIR__ . '/../resources/lang' => $this->langPath('vendor/castle'),
            ]);
        }

        $this->registerLocale();
    }

    protected function registerLocale()
    {
        $locale = $this->app->getLocale();

        Carbon::setLocale($locale);
        CarbonImmutable::setLocale($locale);
    }

    protected function initRegister()
    {
        if (! $this->app->environment('testing')) {
            ini_set('display_errors', 'Off');
        }

        // The only macro that place here, since we need to use this macro in this class.
        /**
         * Deep merge array.
         * Combine (instead of replace) array with the same key (if the value is an array).
         *
         * @param  mixed  $args,...
         * @return array
         */
        Arr::macro('mergeDeep', function (...$args) {
            $result = [];

            foreach ($args as $array) {
                foreach (Arr::wrap($array) as $key => $value) {
                    if (is_integer($key)) {
                        $result[] = $value;
                    } elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                        $result[$key] = Arr::mergeDeep($result[$key], $value);
                    } else {
                        $result[$key] = $value;
                    }
                }
            }

            return $result;
        });
    }

    protected function mergeConfig($key, $otherConfig = null)
    {
        if (
            ! $this->isConfigLoaded($key) ||
            ($this->isConfigLoaded($key) && ! file_exists($this->configPath($key . '.php')))
        ) {
            $config = $this->app->make('config');

            $config->set($key, Arr::mergeDeep(
                $config->get($key, []),
                is_array($otherConfig) ? $otherConfig : require __DIR__ . "/../config/$key.php"
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
}
