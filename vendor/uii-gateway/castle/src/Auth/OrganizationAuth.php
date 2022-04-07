<?php

namespace UIIGateway\Castle\Auth;

use Illuminate\Support\Collection;
use UIIGateway\Castle\Repositories\OrganizationRepository;

class OrganizationAuth
{
    protected OrganizationRepository $organizationRepository;

    protected array $organizationCodes;

    protected Collection $organizations;

    protected Collection $organizationsAndChildren;

    public function __construct(OrganizationRepository $organizationRepository, array $organizationCodes)
    {
        $this->organizationRepository = $organizationRepository;
        $this->organizationCodes = $organizationCodes;
    }

    public function organizationsAndChildren()
    {
        if (! isset($this->organizationsAndChildren)) {
            $this->organizationsAndChildren = $this->organizations()->merge(
                $this->organizationRepository
                    ->getAllChildrenByKdOrganisasi($this->organizationCodes)
            );
        }

        return $this->organizationsAndChildren;
    }

    public function organizations()
    {
        if (! isset($this->organizations)) {
            $this->organizations = $this->organizationRepository
                ->getOrganisasiByKdOrganisasi($this->organizationCodes);
        }

        return $this->organizations;
    }
}
