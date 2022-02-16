<?php

namespace App\Repositories;

use App\DomainModel\Example;
use App\Models\ContohModel;
use App\Repositories\Contracts\ExampleRepositoryContract;
use App\ValueObject\ExampleInformation;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use UIIGateway\Castle\Repositories\BaseRepository;

class ExampleRepository extends BaseRepository implements ExampleRepositoryContract
{
    public function all()
    {
        $results = ContohModel::all();

        return $this->mapToDomainModel($results);
    }

    public function findByUuid(string $uuid)
    {
        $result = DB::table('example')->whereUuid($uuid)->first();

        return $this->toDomainModel((array) $result);
    }

    public function save(Example $example)
    {
        if (is_null($example->uuid())) {
            $this->insert($example);
        } else {
            $this->update($example);
        }
    }

    public function findByOrganizationId(string $organizationId)
    {
        $result = DB::table('example')
            ->whereIn('id_organisasi', $organizationId)
            ->first();

        if (is_null($result)) {
            return null;
        }

        return $this->toDomainModel((array) $result);
    }

    protected function insert(Example $example)
    {
        throw new Exception('Not implemented.');
    }

    protected function update(Example $example)
    {
        $record = $this->eloquentFindByUuid($example->uuid());

        if (is_null($record)) {
            throw new InvalidArgumentException('Failed to get record for update.');
        }

        return $record->forceFill([
            'id_organisasi' => $example->organizationId(),
        ])->save();
    }

    public function remove(Example $example)
    {
        DB::table('example')
            ->where('uuid', $example->uuid())
            ->delete();
    }

    protected function eloquentFindByUuid(string $uuid)
    {
        return ContohModel::whereUuid($uuid)->first();
    }

    protected function toDomainModel(array $data)
    {
        return new \App\DomainModel\Example(new ExampleInformation(
            $data['id'],
            $data['uuid'],
            $data['id_organisasi']
        ));
    }
}
