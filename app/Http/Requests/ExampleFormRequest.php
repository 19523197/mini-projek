<?php

namespace App\Http\Requests;

use App\Rules\ExampleRule;

class ExampleFormRequest extends FormRequest
{
    protected function authorize(): bool
    {
        return true;
    }

    protected function rules(): array
    {
        return [
            'example_field1' => ['required', 'integer', new ExampleRule()],
            'example_field2' => ['required', 'json'],
        ];
    }
}
