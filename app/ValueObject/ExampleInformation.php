<?php

namespace App\ValueObject;

class ExampleInformation
{
    public ?string $id;

    public ?string $uuid;

    public ?string $organizationId;

    public function __construct(
        ?string $id,
        ?string $uuid,
        ?string $organizationId
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->organizationId = $organizationId;
    }
}
