<?php

namespace App\Http\Controllers\Private\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExampleResource;
use Illuminate\Http\Request;

class ExamplePrivateApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'example_field1' => ['required', 'integer'],
            'example_field2' => ['required', 'string'],
        ]);

        return ExampleResource::collection([])
            ->additional([
                'info' => __('Contoh pesan respon.')
            ]);
    }
}
