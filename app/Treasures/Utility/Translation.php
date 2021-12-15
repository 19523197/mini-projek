<?php

namespace App\Treasures\Utility;

use Exception;
use Illuminate\Support\Str;

class Translation
{
    public static function transEntity(string $entity)
    {
        try {
            // try to get the class name if it's a class
            $entity = Str::snake(class_basename(new $entity));
        } catch (Exception $e) {
            //
        }

        $entity = Str::lower(str_replace('_', ' ', $entity));

        return Str::title(($result = __($entity)) ? $result : $entity);
    }
}
