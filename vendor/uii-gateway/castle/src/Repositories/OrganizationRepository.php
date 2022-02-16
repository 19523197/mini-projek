<?php

namespace UIIGateway\Castle\Repositories;

interface OrganizationRepository
{
    /**
     * @return \UIIGateway\Castle\DomainModel\Organisasi|null
     */
    public function findByUuid(string $uuid);

    /**
     * @return \Illuminate\Support\Collection<\UIIGateway\Castle\DomainModel\Organisasi>
     */
    public function getOrganisasiByKdOrganisasi(array $organizationCodes);

    /**
     * @return \Illuminate\Support\Collection<\UIIGateway\Castle\DomainModel\Organisasi>
     */
    public function getOrganisasiByIndukOrganisasi(array $organizationCodes);

    /**
     * @return \Illuminate\Support\Collection<\UIIGateway\Castle\DomainModel\Organisasi>
     */
    public function getOrganisasiAndAllChildrenByKdOrganisasi(array $organizationCodes);

    /**
     * @return \Illuminate\Support\Collection<\UIIGateway\Castle\DomainModel\Organisasi>
     */
    public function getAllChildrenByKdOrganisasi(array $organizationCodes);
}
