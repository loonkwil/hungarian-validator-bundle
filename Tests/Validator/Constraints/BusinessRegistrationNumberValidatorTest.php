<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\BusinessRegistrationNumber;
use SPE\HungarianValidatorBundle\Validator\BusinessRegistrationNumberValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class BusinessRegistrationNumberValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
      return new BusinessRegistrationNumberValidator();
    }

    /**
     * @dataProvider provideInvalidBusinessRegistrationNumbers
     */
    public function testInvalidBusinessRegistrationNumbers($value)
    {
        $this->validator->validate($value, new BusinessRegistrationNumber());
        $this->buildViolation("It is not a valid business registration number")
            ->assertRaised();
    }

    public function provideInvalidBusinessRegistrationNumbers()
    {
        return [
            ['01 090 562739'],
            ['A1 09 562739'],
            ['21 09 562739'],
            ['01 33 562739'],
        ];
    }

    /**
     * @dataProvider provideValidBusinessRegistrationNumbers
     */
    public function testValidBusinessRegistrationNumbers($value)
    {
        $this->validator->validate($value, new BusinessRegistrationNumber());
        $this->assertNoViolation();
    }

    public function provideValidBusinessRegistrationNumbers()
    {
        return [
            ['01-09-562739'],
            ['01 09 562739'],
            ['0109562739'],
        ];
    }
}
