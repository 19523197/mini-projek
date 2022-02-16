<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use UIIGateway\Castle\Rules\BaseRule;

class ExampleRule extends BaseRule implements Rule
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
