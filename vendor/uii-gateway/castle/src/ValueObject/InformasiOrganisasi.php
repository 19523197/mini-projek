<?php

namespace UIIGateway\Castle\ValueObject;

class InformasiOrganisasi
{
    public string $id;

    public string $uuid;

    public ?string $indukOrganisasi;

    public string $kdOrganisasi;

    public string $namaOrganisasi;

    public ?string $namaOrganisasiEn;

    public ?string $namaSingkat;

    public function __construct(
        string $id,
        string $uuid,
        ?string $indukOrganisasi,
        string $kdOrganisasi,
        string $namaOrganisasi,
        ?string $namaOrganisasiEn,
        ?string $namaSingkat
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->indukOrganisasi = $indukOrganisasi;
        $this->kdOrganisasi = $kdOrganisasi;
        $this->namaOrganisasi = $namaOrganisasi;
        $this->namaOrganisasiEn = $namaOrganisasiEn;
        $this->namaSingkat = $namaSingkat;
    }
}
