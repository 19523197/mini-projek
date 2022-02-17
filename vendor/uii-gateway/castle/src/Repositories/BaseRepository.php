<?php

namespace UIIGateway\Castle\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    protected abstract function toDomainModel(array $data);

    protected function mapToDomainModel(Collection $data)
    {
        return $data->map(fn ($item) => $this->toDomainModel(
            $item instanceof Model
                ? $item->toArray()
                : (array) $item
        ));
    }
}
