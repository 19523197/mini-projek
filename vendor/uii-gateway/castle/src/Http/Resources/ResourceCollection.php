<?php

namespace UIIGateway\Castle\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection as BaseResource;
use Illuminate\Support\Collection;

class ResourceCollection extends BaseResource
{
    use JsonResourceOverride;

    public function __construct($resource)
    {
        if (is_array($resource)) {
            $resource = new Collection($resource);
        }

        parent::__construct($resource);
    }
}
