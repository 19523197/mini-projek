<?php

namespace UIIGateway\Castle\Rules;

use UIIGateway\Castle\Utility\ReflectionHelper;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Str;

abstract class BaseRule implements ValidatorAwareRule
{
    /**
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    protected function preprocessParameters($attribute, array $parameters): array
    {
        $keys = ReflectionHelper::callRestrictedMethod($this->validator, 'getExplicitKeys', [$attribute]);

        if ($keys) {
            $parameters = ReflectionHelper::callRestrictedMethod(
                $this->validator,
                'replaceAsterisksInParameters',
                [$parameters, $keys]
            );
        }

        return $parameters;
    }

    protected function formatMessage(array $replaces = [])
    {
        foreach ($replaces as $key => $replace) {
            $replaces[$key] = $this->validator->getDisplayableAttribute($replace);
        }

        return trans('validation.' . Str::snake(class_basename($this)), $replaces);
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }
}
