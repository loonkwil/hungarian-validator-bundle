<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\TaxId;
use SPE\HungarianValidatorBundle\Validator\TaxIdValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TaxIdValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new TaxIdValidator();
    }

    /**
     * @dataProvider provideInvalidTaxIds
     */
    public function testInvalidTaxIds($value)
    {
        $this->validator->validate($value, new TaxId());
        $this->buildViolation("It is not a valid tax ID")
            ->assertRaised();
    }

    public function provideInvalidTaxIds()
    {
        return [
            ['832825870'],
            ['8 32825 870 9'],
            ['8 12825 870 8'],
            ['1 32825 870 8'],
        ];
    }

    /**
     * @dataProvider provideValidTaxIds
     */
    public function testValidTaxIds($value)
    {
        $this->validator->validate($value, new TaxId());
        $this->assertNoViolation();
    }

    public function provideValidTaxIds()
    {
        return [
            ['8 32825 870 6'],
            ['8-32825-870-6'],
            ['8328258706'],
        ];
    }
}
