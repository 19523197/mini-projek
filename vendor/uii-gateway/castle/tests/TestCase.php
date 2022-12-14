<?php

namespace UIIGateway\Castle\Tests;

use UIIGateway\Castle\ServiceProvider;
use UIIGateway\Castle\Testing\TestingMixins;
use UIIGateway\Castle\Tests\Concerns\CreatesApplication;
use PHPUnit\Framework\TestCase as PHPUnit;

abstract class TestCase extends PHPUnit
{
    use CreatesApplication;
    use TestingMixins;

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
        $this->setUpTestEnvironment();
    }

    protected function serviceProviders(): array
    {
        return [
            ServiceProvider::class
        ];
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

    protected function fixturesPath($path)
    {
        return realpath(__DIR__ . '/fixtures/' . ltrim($path, '/'));
    }
}
