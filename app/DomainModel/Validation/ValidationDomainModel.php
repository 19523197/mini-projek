<?php

namespace App\DomainModel\Validation;

use App\ValueObject\Validation\ValidationValueObject;

class ValidationDomainModel
{
    public ValidationValueObject $information;

    public function __construct(ValidationValueObject $information)
    {
        $this->information = $information;
    }

    /**
     * Declare function about data variable
     */

    public function id()
    {
        return $this->information->id;
    }

    public function uuid()
    {
        return $this->information->uuid;
    }

    public function organizationId()
    {
        return $this->information->organizationId;
    }
}
