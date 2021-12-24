<?php

namespace App\Exceptions;

use App\Treasures\Utility\Translation;
use Illuminate\Support\Str;
use RuntimeException;

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
