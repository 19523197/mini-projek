<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Validation\ValidationRequest;
use App\Http\Resources\Validation\ValidationResource;
use App\Repositories\Validation\ValidationRepository;
use App\Services\Validation\ValidationService;
use Illuminate\Http\Request;

/**
 * This the main controller in this MVP
 */
class ValidationController extends Controller
{
    /**
     * Class variable
     */
    protected $service;
    protected $repository;

    /**
     * First function run
     * This will handle before the objective function is executed, the __construct function will be executed first
     *
     * So, if you want to run some logic first, you can add that logic in this function
     *
     * @param ValidationService $service
     * @param ValidationRepository $repository
     */
    public function __construct(ValidationService $service, ValidationRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Display list all data
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return ValidationResource::collection($this->repository->all());
    }

    /**
     * Display detail data
     *
     * @param string $uuid
     * @return void
     */
    public function show($uuid)
    {
        return ValidationResource::make($this->repository->findByUuid($uuid));
    }

    /**
     * Create new data
     *
     * @param ValidationRequest $request
     * @return void
     */
    public function create(ValidationRequest $request)
    {
        $this->service->create($request->validated());

        return $this->responseCreated('contoh');
    }

    /**
     * Update data by uuid
     *
     * @param ValidationRequest $request
     * @param string $uuid
     * @return void
     */
    public function update(ValidationRequest $request, $uuid)
    {
        $this->service->update($uuid, $request->validated());

        return $this->responseUpdated('contoh');
    }

    /**
     * Destroy data by uuid
     *
     * @param string $uuid
     * @return void
     */
    public function destroy($uuid)
    {
        $this->service->destroy($uuid);

        return $this->responseDeleted('contoh');
    }
}
