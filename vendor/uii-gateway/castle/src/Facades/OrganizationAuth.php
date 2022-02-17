<?php

namespace UIIGateway\Castle\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection organizations()
 * @method static \Illuminate\Support\Collection organizationsAndChildren()
 */
class OrganizationAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \UIIGateway\Castle\Auth\OrganizationAuth::class;
    }
}
