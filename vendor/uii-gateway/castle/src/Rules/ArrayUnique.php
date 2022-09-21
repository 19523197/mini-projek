<?php

namespace UIIGateway\Castle\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use UIIGateway\Castle\Utility\ReflectionHelper;

class ArrayUnique extends BaseRule implements Rule
{
    public function passes($attribute, $value)
    {
        $primaryAttribute = ReflectionHelper::callRestrictedMethod(
            $this->validator,
            'getPrimaryAttribute',
            [$attribute]
        );

        $values = Arr::wrap(data_get($this->validator->getData(), $primaryAttribute));

        $matchValues = Arr::where($values, fn ($item) => $item === $value);

        return count($matchValues) === 1;
    }

    public function message()
    {
        return $this->getValidationMessage();
    }
}
