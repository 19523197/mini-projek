<?php

namespace App\Http\Resources;

use App\Treasures\Illuminate\Http\Resources\Resource;

/**
 * @mixin \App\Models\Organisasi
 */
class AnotherExampleResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
        ];
    }
}
