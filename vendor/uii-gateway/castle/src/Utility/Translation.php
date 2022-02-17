<?php

namespace UIIGateway\Castle\Utility;

use Throwable;
use Illuminate\Support\Str;

class Translation
{
    public static function transEntity(string $entity)
    {
        if (class_exists($entity)) {
            // try to get the class name if it's a class
            try {
                $entity = Str::snake(class_basename(new $entity));
            } catch (Throwable $e) {
                //
            }
        }

        $entity = Str::lower(str_replace('_', ' ', $entity));

        return Str::title(($result = __($entity)) ? $result : $entity);
    }
}
