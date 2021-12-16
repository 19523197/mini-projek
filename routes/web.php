<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('public/api/v1', function () use ($router) {
    return response()->json([
        'info' => 'Welcome to Microservice Boilerplate',
    ]);
});

$router->get('/healthz', function () {
    return response(null, 200);
});

$router->group([
    'prefix' => 'public/api/v1',
    'middleware' => ['header']
], function () use ($router) {
    $router->get('/', 'ExampleController');
});

$router->group(['prefix' => '/private/api/v1'], function () use ($router) {
    //
});
