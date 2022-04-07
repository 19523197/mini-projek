<?php

namespace UIIGateway\Castle\Providers;

use Illuminate\Database\DetectsLostConnections;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Str;
use Throwable;

class MiscServiceProvider extends BaseServiceProvider
{
    use DetectsLostConnections;

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
        Queue::popUsing('default', function ($popJobCallback, $queue) {
            $job = null;

            try {
                foreach (explode(',', $queue) as $queue) {
                    if (! is_null($job = $popJobCallback($queue))) {
                        break;
                    }
                }
            } catch (Throwable $e) {
                if (
                    $this->causedByLostConnection($e) ||
                    Str::contains($e->getMessage(), [
                        // phpcs:disable Generic.Files.LineLength.MaxExceeded
                        'SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: nodename nor servname provided, or not known',
                        // phpcs:enable
                    ])
                ) {
                    Cache::increment('LOST_CONNECTION_COUNT');
                }

                throw $e;
            }

            Cache::forget('LOST_CONNECTION_COUNT');

            return $job;
        });
    }
}
