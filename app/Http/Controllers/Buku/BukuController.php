<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buku\BukuRequest;
use App\Http\Resources\Buku\BukuResource;
use App\Repositories\Buku\BukuRepository;
use App\Services\Buku\BukuService;
use Illuminate\Http\Request;

/**
 * This the main controller in this MVP
 */
class BukuController extends Controller
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
     * @param BukuService $service
     * @param BukuRepository $repository
     */
    public function __construct(BukuService $service, BukuRepository $repository)
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
        return BukuResource::collection($this->repository->all());
    }

    /**
     * Display detail data
     *
     * @param string $uuid
     * @return void
     */
    public function show($id)
    {
        return BukuResource::make($this->repository->findByUuid($id));
    }

    /**
     * Create new data
     *
     * @param BukuRequest $request
     * @return void
     */
    public function create(BukuRequest $request)
    {
        $this->service->create($request->validated());

        return $this->responseCreated('contoh');
    }

    /**
     * Update data by uuid
     *
     * @param BukuRequest $request
     * @param string $uuid
     * @return void
     */
    public function update(BukuRequest $request, $uuid)
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
