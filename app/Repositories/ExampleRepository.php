<?php

namespace App\Repositories;

class ExampleRepository
{
    public function add(array $data): array
    {
        return ExampleModel::create($data)->toArray();
    }
}
