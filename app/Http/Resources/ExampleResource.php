<?php

namespace App\Http\Resources;

use App\Treasures\Illuminate\Http\Resources\Resource;

/**
 * @mixin \App\Models\ExampleModel
 */
class ExampleResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'organisasi' => AnotherExampleResource::make($this->whenLoaded('organisasi')),
        ];
    }
}
