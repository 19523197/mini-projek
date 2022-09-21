<?php

namespace UIIGateway\Castle\Tests;

use Illuminate\Support\Facades\Route;
use UIIGateway\Castle\Facades\Auth;
use UIIGateway\Castle\Http\Middleware\HeaderMiddleware;

class AuthTest extends TestCase
{
    public function testAuthFacadeIsWorking()
    {
        $this->app->routeMiddleware([
            'header' => HeaderMiddleware::class,
        ]);

        $xMember = 'johndoe';
        $ctx = $this;

        Route::group(['middleware' => 'header'], function () use ($ctx, $xMember) {
            Route::get('/test-auth', function () use ($ctx, $xMember) {
                $ctx->assertEquals($xMember, Auth::member());
                $ctx->assertEquals(true, Auth::isStudent());
            });
        });

        $this->get('/test-auth', $this->withHeaders([
            'x-member' => $xMember,
            'x-student' => 1,
        ]));
    }
}
