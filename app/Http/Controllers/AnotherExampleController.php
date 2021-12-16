<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExampleResource;
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
        $this->validate($request, [
            'example_field1' => ['required', 'integer', new ExampleRule()],
            'example_field2' => ['required', 'json'],
        ]);

        $example = $this->service->create($request->validated());

        return (new ExampleResource($example))
            ->additional([
                'info' => __('Example response message.')
            ])
            ->response()
            ->setStatusCode(201);
    }
}
