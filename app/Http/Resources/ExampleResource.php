<?php

namespace App\Http\Resources;

use UIIGateway\Castle\Http\Resources\Resource;

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
