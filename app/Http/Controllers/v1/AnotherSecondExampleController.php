<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleFormRequest;
use App\Http\Resources\ExampleResource;
use App\Repositories\Contracts\ExampleRepositoryContract;
use App\Services\ExampleService;
use Illuminate\Http\Request;

class AnotherSecondExampleController extends Controller
{
    protected $service;

    protected $repository;

    public function __construct(
        ExampleService $service,
        ExampleRepositoryContract $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return ExampleResource::collection($this->repository->all());
    }

    public function update(ExampleFormRequest $request, $uuid)
    {
        $this->service->update($uuid, $request->validated());

        return $this->responseUpdated('contoh');
    }

    public function destroy($uuid)
    {
        $this->service->destroy($uuid);

        return $this->responseDeleted('contoh');
    }
}
