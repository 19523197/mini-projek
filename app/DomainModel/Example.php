<?php

namespace App\DomainModel;

use App\ValueObject\ExampleInformation;

class Example
{
    public ExampleInformation $exampleInformation;

    public function __construct(ExampleInformation $exampleInformation)
    {
        $this->exampleInformation = $exampleInformation;
    }

    public function id()
    {
        return $this->exampleInformation->id;
    }

    public function uuid()
    {
        return $this->exampleInformation->uuid;
    }

    public function organizationId()
    {
        return $this->exampleInformation->organizationId;
    }
}
