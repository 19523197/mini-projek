<?php

namespace App\Http\Resources;

use UIIGateway\Castle\Http\Resources\Resource;

class AnotherExampleResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
        ];
    }
}
