<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExampleResource;
use App\Repositories\Contracts\ExampleRepositoryContract;

class ExampleController extends Controller
{
    protected $repository;

    public function __construct(ExampleRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        $examples = $this->repository->getActiveExamplesWithOrganizations();

        return ExampleResource::collection($examples)
            ->additional([
                'info' => __('Contoh pesan respon.')
            ]);
    }
}
