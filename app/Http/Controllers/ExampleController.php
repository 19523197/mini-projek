<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExampleFormRequest;
use App\Http\Resources\ExampleResource;
use App\Models\ExampleModel;
use App\Models\Organisasi;
use App\Rules\ExampleRule;
use Illuminate\Database\Eloquent\Relations\Relation;

class ExampleController extends Controller
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
        $examples = ExampleModel::query()
            ->onlyActive()
//            ->with(['organisasi' => function (Relation $query) {
//                $query->onlyActive();
//            }])
            ->get();

        return ExampleResource::collection($examples)
            ->additional([
                'info' => __('Example response message.')
            ]);
    }
}
