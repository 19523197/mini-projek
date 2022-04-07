<?php

namespace UIIGateway\Castle\Testing;

use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Assert as PHPUnit;

/**
 * @mixin \Laravel\Lumen\Testing\TestCase
 */
trait ResponseAssertion
{
    use ManipulateResponse;

    /**
     * Assert that the response has the given errors.
     *
     * @param  string|array  $keys
     * @return $this
     */
    protected function assertValidationErrors($keys = [])
    {
        $this->assertResponseStatus(400);

        $keys = (array) $keys;

        $errors = $this->jsonResponse('info') ?? [];

        if (! is_array($errors)) {
            PHPUnit::assertTrue(false, "Response doesn't contain validation errors.");

            return $this;
        }

        $errorBag = new MessageBag();
        foreach ($errors as $key => $error) {
            foreach (Arr::wrap($error) as $value) {
                $errorBag->add($key, $value);
            }
        }

        foreach ($keys as $key => $value) {
            if (is_int($key)) {
                PHPUnit::assertTrue(
                    $errorBag->has($value),
                    "Response missing validation error with key: $value."
                );
            } else {
                PHPUnit::assertContains(
                    is_bool($value) ? (string) $value : $value,
                    $errorBag->get($key),
                    "Validation error with key [$key] doesn't contain [$value]."
                );
            }
        }

        return $this;
    }

    protected function assertValidationExceptionHas($exception, string $key)
    {
        if (! $exception instanceof ValidationException) {
            PHPUnit::assertEquals(
                true,
                false,
                'Failed asserting that ValidationException is thrown'
            );
        }

        $this->assertArrayHasKey(
            $key,
            $exception->errors(),
            "Validation exception doesn't contain [$key] which should be there."
        );
    }

    protected function assertValidationMessageAreEquals(string $message, string $key, $replace = [])
    {
        $this->assertNotSame(
            $message,
            $key
        );

        $this->assertSame(
            $message,
            __(
                $key,
                $replace
            )
        );
    }

    /**
     * Assert that the response doesn't have the given status code.
     *
     * @param  int  $code
     * @return $this
     */
    protected function dontSeeStatusCode($code)
    {
        PHPUnit::assertNotEquals(
            $code,
            $this->response->getStatusCode(),
            "Unexpected status code {$code} occurred."
        );

        return $this;
    }

    /**
     *  Assert that the JSON response is a superset of the given data.
     *
     * @param  array  $data
     * @return $this
     */
    protected function assertJsonResponse(array $data)
    {
        $json = $this->jsonResponse();
        $subset = array_replace_recursive($json, $data);

        $expected = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $actual = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $message = 'Unable to find JSON: ' . PHP_EOL . PHP_EOL .
            "[{$expected}]" . PHP_EOL . PHP_EOL .
            'within response JSON:' . PHP_EOL . PHP_EOL .
            "[{$actual}]." . PHP_EOL . PHP_EOL;

        PHPUnit::assertTrue($json == $subset, $message);

        return $this;
    }
}
