<?php

namespace UIIGateway\Castle\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isStudent()
 * @method static string member()
 * @method static \Illuminate\Support\Collection organizations()
 * @method static \Illuminate\Support\Collection organizationsAndChildren()
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \UIIGateway\Castle\Auth\Auth::class;
    }
}
