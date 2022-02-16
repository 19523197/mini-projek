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
        $example = $this->repository->findByOrganizationId(96);

        return ExampleResource::make($example)
            ->additional([
                'info' => __('Contoh pesan respon.')
            ]);
    }
}
