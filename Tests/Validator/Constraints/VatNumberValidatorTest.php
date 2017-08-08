<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\VatNumber;
use SPE\HungarianValidatorBundle\Validator\VatNumberValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class VatNumberValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new VatNumberValidator();
    }

    /**
     * @dataProvider provideInvalidVatNumbers
     */
    public function testInvalidVatNumbers($value)
    {
        $this->validator->validate($value, new VatNumber());
        $this->buildViolation("It is not a valid VAT number")
            ->assertRaised();
    }

    public function provideInvalidVatNumbers()
    {
        return [
            ['1013691-4-44'],
            ['10136915-4-60'],
            ['10136915-6-60'],
        ];
    }

    /**
     * @dataProvider provideValidVatNumbers
     */
    public function testValidVatNumbers($value)
    {
        $this->validator->validate($value, new VatNumber());
        $this->assertNoViolation();
    }

    public function provideValidVatNumbers()
    {
        return [
            ['10136915 4 44'],
            ['10136915-4-44'],
            ['10136915444'],
        ];
    }
}
