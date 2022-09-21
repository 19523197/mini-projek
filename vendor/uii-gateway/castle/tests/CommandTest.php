<?php

namespace UIIGateway\Castle\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class CommandTest extends TestCase
{
    public function testVendorPublishCommandIsWorking()
    {
        $this->app->register(DummyServiceProvider::class);

        $publishes = ServiceProvider::pathsToPublish(DummyServiceProvider::class);

        foreach ($publishes as $path) {
            if (File::exists($path)) {
                File::isFile($path)
                    ? File::delete($path)
                    : File::deleteDirectory($path);
            }
        }

        $this->assertArrayHasKey(
            'vendor:publish',
            Artisan::all(),
            'Failed to assert that "vendor:publish" command is registered.'
        );

        Artisan::call('vendor:publish', [
            '--provider' => 'UIIGateway\Castle\Tests\DummyServiceProvider',
            '--no-interaction' => true,
        ]);

        $results = [];
        foreach ($publishes as $path) {
            $results[] = File::exists($path);
        }

        $this->assertTrue(
            count(array_filter($results, fn ($item) => !$item)) === 0,
            'Command "vendor:publish" not working as expected.'
        );
    }
}

class DummyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/fixtures/command-test/origin/a.php' => __DIR__ . '/fixtures/command-test/destination/a.php',
            ], 'g1');

            $this->publishes([
                __DIR__ . '/fixtures/command-test/origin/a-dir' => __DIR__ . '/fixtures/command-test/destination/a-dir'
            ], 'g2');
        }
    }
}
