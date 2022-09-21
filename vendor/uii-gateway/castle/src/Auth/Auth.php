<?php

namespace UIIGateway\Castle\Auth;

use Illuminate\Http\Request;
use UIIGateway\Castle\Facades\OrganizationAuth;

class Auth
{
    public function __construct(
        protected Request $request
    ) {
    }

    public function member(): string
    {
        return $this->request->header('x-member', 'admin');
    }

    public function isStudent(): bool
    {
        return ((int) $this->request->header('x-student', 0)) === 1;
    }

    public function organizations()
    {
        return OrganizationAuth::organizations();
    }

    public function organizationsAndChildren()
    {
        return OrganizationAuth::organizationsAndChildren();
    }
}
