<?php

namespace UIIGateway\Castle\Exceptions;

use Illuminate\Support\Str;
use RuntimeException;
use UIIGateway\Castle\Utility\Translation;

class EntityNotFoundException extends RuntimeException
{
    /**
     * Create a new exception instance.
     *
     * @param  string  $entity
     * @return void
     */
    public function __construct(string $entity)
    {
        parent::__construct(Str::ucfirst(__(':entity tidak ditemukan.', [
            'entity' => Translation::transEntity($entity),
        ])));
    }
}
