<?php

namespace UIIGateway\Castle\Tests;

use UIIGateway\Castle\ServiceProvider;
use UIIGateway\Castle\Tests\Concerns\CreatesApplication;
use PHPUnit\Framework\TestCase as PHPUnit;

abstract class TestCase extends PHPUnit
{
    use CreatesApplication;

    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        (new \Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
            realpath(__DIR__ . '/../')
        ))->bootstrap();

        $this->setUpTestEnvironment();

        $this->app->register(ServiceProvider::class);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $this->tearDownTestEnvironment();
    }
}
