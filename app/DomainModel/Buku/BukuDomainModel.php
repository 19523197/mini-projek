<?php

namespace App\DomainModel\Buku;

use App\ValueObject\Buku\BukuValueObject;

class BukuDomainModel
{
    public BukuValueObject $information;

    public function __construct(BukuValueObject $information)
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
