<?php

namespace UIIGateway\Castle\Repositories\Impl;

use Illuminate\Support\Facades\DB;
use UIIGateway\Castle\Repositories\BaseRepository;
use UIIGateway\Castle\Repositories\OrganizationRepository;
use UIIGateway\Castle\ValueObject\InformasiOrganisasi;

class OrganizationRepositoryMysql extends BaseRepository implements OrganizationRepository
{
    public function findByUuid(string $uuid)
    {
        $result = DB::table('organisasi')
            ->where('kd_organisasi', $uuid)
            ->first();

        if (is_null($result)) {
            return null;
        }

        return $this->toDomainModel((array) $result);
    }

    public function getOrganisasiByKdOrganisasi(array $organizationCodes)
    {
        $results = DB::table('organisasi')
            ->whereIn('kd_organisasi', $organizationCodes)
            ->get();

        return $this->mapToDomainModel($results);
    }

    public function getOrganisasiByIndukOrganisasi(array $organizationCodes)
    {
        $results = $this->internalGetOrganisasiByIndukOrganisasi($organizationCodes);

        return $this->mapToDomainModel($results);
    }

    protected function internalGetOrganisasiByIndukOrganisasi(array $organizationCodes)
    {
        return DB::table('organisasi')
            ->whereIn('induk_organisasi', $organizationCodes)
            ->get();
    }

    public function getOrganisasiAndAllChildrenByKdOrganisasi(array $organizationCodes)
    {
        $organizations = $this->getOrganisasiByKdOrganisasi($organizationCodes);

        $organizations = $organizations->merge(
            $this->getAllChildrenByKdOrganisasi(
                $organizations->map(fn ($organization) => $organization->kdOrganisasi())
                    ->toArray()
            )
        );

        return $this->mapToDomainModel($organizations);
    }

    public function getAllChildrenByKdOrganisasi(array $organizationCodes)
    {
        $organizations = $this->getChildrenOfOrganizations($organizationCodes);

        return $this->mapToDomainModel($organizations);
    }

    protected function getChildrenOfOrganizations(array $organizartionCodes)
    {
        $children = $this->internalGetOrganisasiByIndukOrganisasi($organizartionCodes);

        if ($children->isNotEmpty()) {
            $children = $children->merge($this->getChildrenOfOrganizations(
                $children->map(fn ($organization) => $organization->kd_organisasi)
                    ->toArray()
            ));
        }

        return $children;
    }

    protected function toDomainModel(array $data)
    {
        return new \UIIGateway\Castle\DomainModel\Organisasi(new InformasiOrganisasi(
            $data['id'],
            $data['uuid'],
            $data['induk_organisasi'],
            $data['kd_organisasi'],
            $data['nama_organisasi'],
            $data['nama_organisasi_en'],
            $data['nama_singkat']
        ));
    }
}
