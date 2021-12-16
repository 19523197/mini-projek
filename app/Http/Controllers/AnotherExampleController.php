<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExampleFormRequest;
use App\Http\Resources\ExampleResource;
use App\Models\ExampleModel;

class AnotherExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function __invoke(ExampleFormRequest $request)
    {
        $example = ExampleModel::create($request->validated());

        return (new ExampleResource($example))
            ->additional([
                'info' => __('Example response message.')
            ])
            ->response()
            ->setStatusCode(201);
    }
}
