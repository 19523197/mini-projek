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

/*
|--------------------------------------------------------------------------
| Healthz Routes: To check if this service return response 200
|--------------------------------------------------------------------------
*/
$router->get('/healthz', function () {
    return response(null, 200);
});

/*
|--------------------------------------------------------------------------
| Public Api Routes: To check if public/api/v1 return info
|--------------------------------------------------------------------------
*/
$router->get('/public/api/v1', function () use ($router) {
    return response()->json([
        'info' => 'Welcome to Microservice',
    ]);
});

/*
|--------------------------------------------------------------------------
| Service Public API
|--------------------------------------------------------------------------
|
| Build your public routes here
*/
$router->group([ 'prefix' => '/public/api/v1', 'middleware' => ['header'] ], function () use ($router) {

}); // END_OF_PUBLIC_API_LINE (DONT DELETE THIS)

/*
|--------------------------------------------------------------------------
| Service Private API
|--------------------------------------------------------------------------
|
| Build your private routes here
*/
$router->group(['prefix' => '/private/api/v1', 'namespace' => 'Private'], function () use ($router) {

}); // END_OF_PRIVATE_API_LINE (DONT DELETE THIS)
