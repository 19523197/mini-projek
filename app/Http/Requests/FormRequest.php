<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

abstract class FormRequest extends Request
{
    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected $validator;

    protected function errorMessage(): string
    {
        return 'The given data was invalid.';
    }

    protected function statusCode(): int
    {
        return 400;
    }

    protected function errorResponse(): ?JsonResponse
    {
        return response()->json([
            'message' => $this->errorMessage(),
            'info' => $this->validator->errors()->messages(),
        ], $this->statusCode());
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException();
    }

    protected function validationFailed(): void
    {
        throw new ValidationException($this->validator, $this->errorResponse());
    }

    protected function validationPassed()
    {
        //
    }

    public function validated(): array
    {
        return $this->validator->validated();
    }

    public function validate(): void
    {
        if (false === $this->authorize()) {
            $this->failedAuthorization();
        }

        $this->validator = $this->app->make('validator')
            ->make($this->all(), $this->rules(), $this->messages());

        $attributes = [];
        foreach ($this->rules() as $key => $rule) {
            if (Str::endsWith($key, '_uuid')) {
                $attributes[$key] = $this->validator->getDisplayableAttribute(
                    Str::replaceLast('_uuid', '', $key)
                );
            }
        }

        $this->validator->setAttributeNames(array_merge($attributes, $this->attributes()));

        if ($this->validator->fails()) {
            $this->validationFailed();
        }

        $this->validationPassed();
    }

    public function setContainer($app)
    {
        $this->app = $app;
    }

    protected function authorize(): bool
    {
        return true;
    }

    abstract protected function rules(): array;

    protected function messages(): array
    {
        return [];
    }

    protected function attributes(): array
    {
        return [];
    }
}
