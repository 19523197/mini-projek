<?php

namespace App\Http\Requests;

use App\Rules\ExampleRule;
use UIIGateway\Castle\Http\FormRequest;

class ExampleFormRequest extends FormRequest
{
    protected function authorize(): bool
    {
        return true;
    }

    protected function rules(): array
    {
        return [
            'id_organisasi' => ['required'],
            'example_field1' => ['integer', new ExampleRule()],
            'example_field2' => ['json'],
        ];
    }
}
