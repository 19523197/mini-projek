<?php

namespace UIIGateway\Castle\Exceptions;

use RuntimeException;

class UuidToBinaryException extends RuntimeException
{
    public function __construct(string $message = 'Could not convert uuid to binary.')
    {
        parent::__construct(__($message));
    }
}
