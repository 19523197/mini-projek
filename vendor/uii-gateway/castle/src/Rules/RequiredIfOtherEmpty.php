<?php

namespace UIIGateway\Castle\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class RequiredIfOtherEmpty extends BaseRule implements Rule, ImplicitRule
{
    public function __construct(
        protected string $other,
        protected bool $trim = true,
        protected bool $bypass = false
    ) {
    }

    public function passes($attribute, $value)
    {
        $this->other = $this->preprocessParameters($attribute, [$this->other])[0];
        $otherValue = Arr::get($this->validator->getData(), $this->other);

        return empty($this->trim($value)) && empty($this->trim($otherValue)) ? $this->bypass : true;
    }

    protected function trim($value)
    {
        if (is_string($value) && $this->trim) {
            $value = trim($value);
        }

        return $value;
    }

    public function message()
    {
        return $this->getValidationMessage([
            'other' => $this->validator->getDisplayableAttribute($this->other),
        ]);
    }
}
