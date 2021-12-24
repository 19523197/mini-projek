<?php

namespace App\Repositories;

use App\Models\ContohModel;
use App\Repositories\Contracts\ExampleRepositoryContract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExampleRepository implements ExampleRepositoryContract
{
    public function all(): Collection
    {
        // return new Collection(ContohModel::query()->get()->toArray());
        return DB::table('contoh')->get();
    }

    public function add(array $data, array $entity = null): array
    {
        if ($entity) {
            $entity = (new ContohModel)->newFromBuilder($entity);
            $entity->update($data);

            return $entity->toArray();
        }

        ContohModel::create($data);

        // Since we use trigger, we need to query latest record from DB
        // to get the completed data for the recently created model.
        return $this->last();
    }

    public function remove(array $entity): void
    {
        $entity = (new ContohModel)->newFromBuilder($entity);
        $entity->delete();
    }

    public function findByUuid(string $uuid): ?array
    {
        $instance = ContohModel::whereUuid($uuid)->first();

        if ($instance) {
            $instance = $instance->toArray();
        }

        return $instance;
    }

    public function last(): ?array
    {
        $instance = ContohModel::query()->latest()->first();

        if ($instance) {
            $instance = $instance->toArray();
        }

        return $instance;
    }

    public function getActiveExamplesWithOrganizations(): Collection
    {
        return new Collection(
            ContohModel::query()
                ->onlyActive()
                ->with(['organisasi' => function (Relation $query) {
                    $query->onlyActive();
                }])
                ->get()
                ->toArray()
        );
    }
}
