<?php

namespace UIIGateway\Castle\Tests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use UIIGateway\Castle\Rules\ArrayUnique;
use UIIGateway\Castle\Rules\RequiredIfOtherEmpty;

class RuleTest extends TestCase
{
    public function testArrayUniqueRuleIsWorking()
    {
        $this->expectException(ValidationException::class);

        try {
            Validator::validate([
                'dummy_attribute' => [
                    ['v' => 1],
                    ['v' => 2],
                    ['v' => 3],
                    ['v' => 2],
                ],
            ], [
                'dummy_attribute.*.v' => [
                    new ArrayUnique,
                ],
            ]);
        } catch (ValidationException $e) {
            $this->assertValidationExceptionHas($e, 'dummy_attribute.1.v');
            $this->assertValidationExceptionHas($e, 'dummy_attribute.3.v');

            throw $e;
        }
    }

    public function testRequiredIfOtherEmptyRuleIsWorking()
    {
        $this->expectException(ValidationException::class);

        try {
            Validator::validate([
                'dummy_attribute' => null,
            ], [
                'dummy_attribute' => [
                    new RequiredIfOtherEmpty('other_attribute'),
                ],
            ]);
        } catch (ValidationException $e) {
            $this->assertValidationExceptionHas($e, 'dummy_attribute');

            throw $e;
        }
    }
}
