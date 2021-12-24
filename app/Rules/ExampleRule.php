<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExampleRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return in_array($value, ['value1', 'value2']);
    }

    public function message()
    {
        return __('Contoh pesan kesalahan.');
    }
}
