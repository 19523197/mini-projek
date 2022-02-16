<?php

namespace UIIGateway\Castle\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class RequiredIfOtherEmpty extends BaseRule implements Rule, ImplicitRule
{
    protected $other;

    protected $trim;

    protected $bypass;

    public function __construct(string $other, bool $trim = true, bool $bypass = false)
    {
        $this->other = $other;
        $this->trim = $trim;
        $this->bypass = $bypass;
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
        return $this->formatMessage(['other' => $this->other]);
    }
}
