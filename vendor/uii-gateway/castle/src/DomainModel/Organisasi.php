<?php

namespace UIIGateway\Castle\DomainModel;

use UIIGateway\Castle\ValueObject\InformasiOrganisasi;

class Organisasi
{
    protected InformasiOrganisasi $informasiOrganisasi;

    public function __construct(InformasiOrganisasi $informasiOrganisasi)
    {
        $this->informasiOrganisasi = $informasiOrganisasi;
    }

    public function id()
    {
        return $this->informasiOrganisasi->id;
    }

    public function uuid()
    {
        return $this->informasiOrganisasi->uuid;
    }

    public function indukOrganisasi()
    {
        return $this->informasiOrganisasi->indukOrganisasi;
    }

    public function kdOrganisasi()
    {
        return $this->informasiOrganisasi->kdOrganisasi;
    }

    public function namaOrganisasi()
    {
        return $this->informasiOrganisasi->namaOrganisasi;
    }

    public function namaOrganisasiEn()
    {
        return $this->informasiOrganisasi->namaOrganisasiEn;
    }

    public function namaSingkat()
    {
        return $this->informasiOrganisasi->namaSingkat;
    }

    public function getInformasiOrganisasi()
    {
        return $this->informasiOrganisasi;
    }
}
