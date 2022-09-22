<?php

namespace App\Services\Validation;

use App\DomainModel\Validation\ValidationDomainModel;
use App\Repositories\Validation\ValidationRepository;
use App\ValueObject\Validation\ValidationValueObject;
use Illuminate\Support\Facades\DB;
use UIIGateway\Castle\Exceptions\EntityNotFoundException;

/**
 * Service used to accommodate functions that can be reuseable multiple times
 * Just create public function in this class
 */
class ValidationService
{
    /**
     * Variable used in this class
     */
    protected $repository;

    /**
     * Construct function
     *
     * @param ValidationRepository $repository
     */
    public function __construct(ValidationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create function
     * Just sample, you can replace and customize with your logic
     *
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $this->repository->save(new ValidationDomainModel(new ValidationValueObject(null, null, 2)));
        });
    }

    /**
     * Update function
     * Just sample, you can replace and customize with your logic
     *
     * @param string $uuid
     * @param array $data
     * @return void
     */
    public function update(string $uuid, array $data)
    {
        return DB::transaction(function () use ($uuid, $data) {
            $example = $this->repository->findByUuid($uuid);

            if (is_null($example)) {
                throw new EntityNotFoundException('contoh');
            }

            $example->information->organizationId = $data['organisasi_id'];

            $this->repository->save($example);

            return $example;
        });
    }

    /**
     * Destroy function
     * Just sample, you can replace and customize with your logic
     *
     * @param string $uuid
     * @return void
     */
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

    /**
     * Other function
     * Just sample, you can replace and customize with your logic
     *
     * @param string $sampleData
     * @return void
     */
    public function otherFunction($sampleData)
    {
        /**
         * You can customize what will this function do
         */
        return $sampleData;
    }
}
