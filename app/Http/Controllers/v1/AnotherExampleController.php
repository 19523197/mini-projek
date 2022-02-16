<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Rules\ExampleRule;
use App\Services\ExampleService;
use Illuminate\Http\Request;

class AnotherExampleController extends Controller
{
    protected $service;

    public function __construct(ExampleService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $requestData = $this->validate($request, [
            'id_organisasi' => ['required'],
            'example_field1' => ['integer', new ExampleRule()],
            'example_field2' => ['json'],
        ]);

        $this->service->create($requestData);

        return $this->responseCreated('contoh');
    }
}
