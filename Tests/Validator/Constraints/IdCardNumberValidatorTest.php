<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\IdCardNumber;
use SPE\HungarianValidatorBundle\Validator\IdCardNumberValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class IdCardNumberValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new IdCardNumberValidator();
    }

    /**
     * @dataProvider provideInvalidIdCardNumbers
     */
    public function testInvalidIdCardNumbers($value)
    {
        $this->validator->validate($value, new IdCardNumber());
        $this->buildViolation("It is not a valid personal ID card number")
            ->assertRaised();
    }

    public function provideInvalidIdCardNumbers()
    {
        return [
            ['123456A'],
        ];
    }

    /**
     * @dataProvider provideValidIdCardNumbers
     */
    public function testValidIdCardNumbers($value)
    {
        $this->validator->validate($value, new IdCardNumber());
        $this->assertNoViolation();
    }

    public function provideValidIdCardNumbers()
    {
        return [
            ['123456 AA'],
            ['123456-AA'],
            ['123456AA'],
        ];
    }
}
