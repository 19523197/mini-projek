<?php

namespace UIIGateway\Castle\Publishing\Contracts;

interface Factory
{
    /**
     * Get a publisher implementation by name.
     *
     * @param  string|null  $name
     * @return \UIIGateway\Castle\Publishing\Contracts\Publisher
     */
    public function connection($name = null);
}
