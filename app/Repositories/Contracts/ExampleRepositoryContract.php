<?php

namespace App\Repositories\Contracts;

use App\DomainModel\Example;

interface ExampleRepositoryContract
{
    /**
     * @return \Illuminate\Support\Collection<\App\DomainModel\Example>
     */
    public function all();

    /**
     * @return \App\DomainModel\Example|null
     */
    public function findByUuid(string $uuid);

    /**
     * @return void
     */
    public function save(Example $example);

    /**
     * @return void
     */
    public function remove(Example $example);

    /**
     * @return \App\DomainModel\Example|null
     */
    public function findByOrganizationId(string $organizationId);
}
