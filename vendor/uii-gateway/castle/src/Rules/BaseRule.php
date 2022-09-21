<?php

namespace UIIGateway\Castle\Rules;

use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Str;
use UIIGateway\Castle\Utility\ReflectionHelper;

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

    protected function getValidationMessage(array $replaces = [], ?string $namespace = 'castle')
    {
        if ($namespace) {
            $key = $namespace . '::validation.' . Str::snake(class_basename($this));
            $trans = trans($key, $replaces);

            if ($trans !== $key) {
                return $trans;
            }

            // fallback to the main validation translation.
        }

        return trans('validation.' . Str::snake(class_basename($this)), $replaces);
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }
}
