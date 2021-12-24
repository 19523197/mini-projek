<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ExampleRepositoryContract
{
    public function all(): Collection;

    public function add(array $data, array $entity = null): array;

    public function remove(array $entity): void;

    public function last(): ?array;

    public function getActiveExamplesWithOrganizations(): Collection;

    public function findByUuid(string $uuid): ?array;
}
