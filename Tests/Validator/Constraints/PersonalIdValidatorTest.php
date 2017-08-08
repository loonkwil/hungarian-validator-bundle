<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\PersonalId;
use SPE\HungarianValidatorBundle\Validator\PersonalIdValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class PersonalIdValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new PersonalIdValidator();
    }

    /**
     * @dataProvider provideInvalidPersonalIds
     */
    public function testInvalidPersonalIds($value)
    {
        $this->validator->validate($value, new PersonalId());
        $this->buildViolation("It is not a valid personal ID")
            ->assertRaised();
    }

    public function provideInvalidPersonalIds()
    {
        return [
            ['3-110714-122'],
            ['2 780230 1233'],
            ['3-110714-1233'],
        ];
    }

    /**
     * @dataProvider provideValidPersonalIds
     */
    public function testValidPersonalIds($value)
    {
        $this->validator->validate($value, new PersonalId());
        $this->assertNoViolation();
    }

    public function provideValidPersonalIds()
    {
        return [
            ['3 110714 1231'],
            ['3-110714-1231'],
            ['31107141231'],
        ];
    }
}
