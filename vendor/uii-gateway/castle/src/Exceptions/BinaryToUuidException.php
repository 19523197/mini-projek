<?php

namespace UIIGateway\Castle\Exceptions;

use RuntimeException;

class BinaryToUuidException extends RuntimeException
{
    public function __construct(string $message = 'Could not convert binary to uuid.')
    {
        parent::__construct(__($message));
    }
}
