<?php

namespace App\Repositories\Validation;

use App\DomainModel\Validation\ValidationDomainModel;
use App\Models\User;
use App\ValueObject\Validation\ValidationValueObject;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use UIIGateway\Castle\Repositories\BaseRepository;

class ValidationRepository extends BaseRepository
{
    /**
     * Logic to get all data from table database
     * This just sample with ContohModel, you can replace with your logic
     *
     * @return void
     */
    public function all()
    {
        $results = User::all();

        /**
         * If return data is collection (more than 1) use mapToDomainModel
         */
        return $this->mapToDomainModel($results);
    }

    /**
     * Logic to get data by uuid from table database with query builder
     * This just sample with example table, you can replace with your logic
     *
     * @param string $uuid
     * @return void
     */
    public function findByUuid(string $id)
    {
        $result = DB::table('users')->whereUuid($id)->first();

        /**
         * If return data is single (no more than 1) use toDomainModel
         */
        return $this->toDomainModel((array) $result);
    }

    /**
     * Logic to save data
     * This just sample, you can replace with your logic
     *
     * @param ValidationDomainModel $example
     * @return void
     */
    public function save(ValidationDomainModel $example)
    {
        if (is_null($example->uuid())) {
            $this->insert($example);
        } else {
            $this->update($example);
        }
    }

    /**
     * Logic insert data to database
     * This just sample, for now not implemented, you can replace with your logic to save data to database
     *
     * @param ValidationDomainModel $example
     * @return void
     */
    protected function insert(ValidationDomainModel $example)
    {
        throw new Exception('Not implemented.');
    }

    /**
     * Logic update data to database
     * This just sample, you can replace with your logic to save data to database
     *
     * @param ValidationDomainModel $example
     * @return void
     */
    protected function update(ValidationDomainModel $example)
    {
        $record = $this->eloquentFindByUuid($example->uuid());

        if (is_null($record)) {
            throw new InvalidArgumentException('Failed to get record for update.');
        }

        return $record->forceFill([
            'id_organisasi' => $example->organizationId(),
        ])->save();
    }

    /**
     * Logic remove data from database
     * This just sample with example table, you can replace with your logic to save data to database
     *
     * @param ValidationDomainModel $example
     * @return void
     */
    public function remove(ValidationDomainModel $example)
    {
        DB::table('user')
            ->where('id', $example->uuid())
            ->delete();
    }

    /**
     * Logic to get data by uuid from table database with eloquent
     * This just sample with ContohModel, you can replace with your logic
     *
     * @param string $uuid
     * @return void
     */
    protected function eloquentFindByUuid(string $uuid)
    {
        return User::whereUuid($uuid)->first();
    }

    /**
     * Logic map data to domain model
     * This just sample, you can add and/or replace with your logic
     *
     * @param string $uuid
     * @return void
     */
    protected function toDomainModel(array $data)
    {
        return new ValidationDomainModel(new ValidationValueObject(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['password']
        ));
    }
}
