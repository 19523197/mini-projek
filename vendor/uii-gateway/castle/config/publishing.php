<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Publisher
    |--------------------------------------------------------------------------
    |
    | This option controls the default publisher that will be used by the
    | framework when an event needs to be publish. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "kafka", "log", "null"
    |
    */

    'default' => env('PUBLISH_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'kafka' => [
            'driver' => 'kafka',
            'brokers' => env('KAFKA_BROKERS', 'localhost:9092'),
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
