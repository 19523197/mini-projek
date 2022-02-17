<?php

namespace UIIGateway\Castle\Providers;

use DateTimeInterface;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class MacroServiceProvider extends BaseServiceProvider
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
        /**
         * Get a temporary URL for the file at the given path (with an alias).
         *
         * @param  string  $path
         * @param  \DateTimeInterface  $expiration
         * @param  array  $options
         * @return string
         *
         * @throws \RuntimeException
         */
        FilesystemAdapter::macro(
            'temporaryUrlAs',
            function (string $path, string $name, DateTimeInterface $expiration, array $options = []) {
                return $this->temporaryUrl(
                    $path,
                    $expiration,
                    array_merge([
                        'ResponseContentDisposition' => "inline; filename=$name",
                    ], $options)
                );
            }
        );

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

        /**
         * Deep merge array to the collection.
         *
         * @param  mixed  $items
         * @return \Illuminate\Support\Collection
         */
        Collection::macro('mergeDeep', function ($items) {
            return new static(Arr::mergeDeep($this->items, $this->getArrayableItems($items)));
        });
    }
}
