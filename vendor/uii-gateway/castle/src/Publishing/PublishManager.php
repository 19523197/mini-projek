<?php

namespace UIIGateway\Castle\Publishing;

use Closure;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcherContract;
use InvalidArgumentException;
use Junges\Kafka\Kafka;
use Psr\Log\LoggerInterface;
use UIIGateway\Castle\Publishing\Contracts\Factory as FactoryContract;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublishAndBroadcastNow;
use UIIGateway\Castle\Publishing\Contracts\ShouldPublishNow;
use UIIGateway\Castle\Publishing\Publishers\KafkaPublisher;
use UIIGateway\Castle\Publishing\Publishers\LogPublisher;
use UIIGateway\Castle\Publishing\Publishers\NullPublisher;

/**
 * @mixin \UIIGateway\Castle\Publishing\Contracts\Publisher
 */
class PublishManager implements FactoryContract
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * The array of resolved publish drivers.
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Begin publishing an event.
     *
     * @param  mixed|null  $event
     * @return \UIIGateway\Castle\Publishing\PendingPublish
     */
    public function event($event = null)
    {
        return new PendingPublish($this->app->make('events'), $event);
    }

    /**
     * Queue the given event for publish.
     *
     * @param  mixed  $event
     * @return void
     */
    public function queue($event)
    {
        if (
            $event instanceof ShouldPublishNow ||
            $event instanceof ShouldPublishAndBroadcastNow ||
            (is_object($event) &&
                method_exists($event, 'shouldPublishNow') &&
                $event->shouldPublishNow())
        ) {
            return $this->app->make(BusDispatcherContract::class)
                ->dispatchNow(new PublishEvent(clone $event));
        }

        $queue = null;

        if (method_exists($event, 'publishQueue')) {
            $queue = $event->publishQueue();
        } elseif (isset($event->publishQueue)) {
            $queue = $event->publishQueue;
        } elseif (isset($event->queue)) {
            $queue = $event->queue;
        }

        $this->app->make('queue')->connection($event->connection ?? null)->pushOn(
            $queue, new PublishEvent(clone $event)
        );
    }

    /**
     * Get a driver instance.
     *
     * @param  string|null  $driver
     * @return mixed
     */
    public function connection($driver = null)
    {
        return $this->driver($driver);
    }

    /**
     * Get a driver instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function driver($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->drivers[$name] = $this->get($name);
    }

    /**
     * Attempt to get the connection from the local cache.
     *
     * @param  string  $name
     * @return \UIIGateway\Castle\Publishing\Publishers\Publisher
     */
    protected function get($name)
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given publisher.
     *
     * @param  string  $name
     * @return \UIIGateway\Castle\Publishing\Publishers\Publisher
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (isset($this->customCreators[$config['driver']])) {
            return $this->callCustomCreator($config);
        }

        $driverMethod = 'create' . ucfirst($config['driver']) . 'Driver';

        if (! method_exists($this, $driverMethod)) {
            throw new InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
        }

        return $this->{$driverMethod}($config);
    }

    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return mixed
     */
    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $config);
    }

    /**
     * Create an instance of Kafka the driver.
     *
     * @param  array  $config
     * @return \UIIGateway\Castle\Publishing\Publishers\Publisher
     */
    protected function createKafkaDriver(array $config)
    {
        $kafkaProducer = $this->app->make(Kafka::class)
            ->publishOn('', $config['brokers']);

        return new KafkaPublisher($kafkaProducer);
    }

    /**
     * Create an instance of the log driver.
     *
     * @param  array  $config
     * @return \UIIGateway\Castle\Publishing\Publishers\Publisher
     */
    protected function createLogDriver(array $config)
    {
        return new LogPublisher(
            $this->app->make(LoggerInterface::class)
        );
    }

    /**
     * Create an instance of the null driver.
     *
     * @param  array  $config
     * @return \UIIGateway\Castle\Publishing\Publishers\Publisher
     */
    protected function createNullDriver(array $config)
    {
        return new NullPublisher;
    }

    /**
     * Get the connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        if (! is_null($name) && $name !== 'null') {
            return $this->app['config']["publishing.connections.{$name}"];
        }

        return ['driver' => 'null'];
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['publishing.default'];
    }

    /**
     * Set the default driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['publishing.default'] = $name;
    }

    /**
     * Disconnect the given disk and remove from local cache.
     *
     * @param  string|null  $name
     * @return void
     */
    public function purge($name = null)
    {
        $name = $name ?? $this->getDefaultDriver();

        unset($this->drivers[$name]);
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  string  $driver
     * @param  \Closure  $callback
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }

    /**
     * Get the application instance used by the manager.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function getApplication()
    {
        return $this->app;
    }

    /**
     * Set the application instance used by the manager.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return $this
     */
    public function setApplication($app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Forget all of the resolved driver instances.
     *
     * @return $this
     */
    public function forgetDrivers()
    {
        $this->drivers = [];

        return $this;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
