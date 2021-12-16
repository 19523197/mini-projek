<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExampleFormRequest;
use App\Http\Resources\BazaarClass\BazaarClassResource;
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
        // choose one implementation.
        // via FormRequest (ExampleFormRequest) or via $this->validate(), but not both.
        $this->validate($request, [
            'example_field1' => ['required', 'integer', new ExampleRule()],
            'example_field2' => ['required', 'json'],
        ]);

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
