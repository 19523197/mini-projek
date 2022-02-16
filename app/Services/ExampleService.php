<?php

namespace App\Services;

use App\DomainModel\Example;
use App\Repositories\Contracts\ExampleRepositoryContract;
use App\ValueObject\ExampleInformation;
use Illuminate\Support\Facades\DB;
use UIIGateway\Castle\Exceptions\EntityNotFoundException;

class ExampleService
{
    protected $repository;

    public function __construct(ExampleRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $this->repository->save(new Example(new ExampleInformation(
                null,
                null,
                2
            )));
        });
    }

    public function update(string $uuid, array $data)
    {
        return DB::transaction(function () use ($uuid, $data) {
            $example = $this->repository->findByUuid($uuid);

            if (is_null($example)) {
                throw new EntityNotFoundException('contoh');
            }

            $example->exampleInformation->organizationId = $data['organisasi_id'];

            $this->repository->save($example);

            return $example;
        });
    }

    public function destroy(string $uuid): void
    {
        DB::transaction(function () use ($uuid) {
            $example = $this->repository->findByUuid($uuid);

            if (is_null($example)) {
                throw new EntityNotFoundException('contoh');
            }

            $this->repository->remove($example);
        });
    }
}
