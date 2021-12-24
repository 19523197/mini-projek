<?php

namespace App\Services;

use App\Exceptions\EntityNotFoundException;
use App\Repositories\Contracts\ExampleRepositoryContract;

class ExampleService
{
    protected $repository;

    public function __construct(ExampleRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): array
    {
        return $this->repository->add($data);
    }

    public function update(string $uuid, array $data): array
    {
        $example = $this->repository->findByUuid($uuid);

        if (is_null($example)) {
            throw new EntityNotFoundException('contoh');
        }

        return $this->repository->add($data, $example);
    }

    public function destroy(string $uuid): void
    {
        $example = $this->repository->findByUuid($uuid);

        if (is_null($example)) {
            throw new EntityNotFoundException('contoh');
        }

        $this->repository->remove($example);
    }
}
