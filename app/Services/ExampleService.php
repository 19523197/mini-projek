<?php

namespace App\Services;

use App\Repositories\ExampleRepository;

class ExampleService
{
    protected $repository;

    public function __construct(ExampleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): array
    {
        return $this->repository->add($data);
    }
}
