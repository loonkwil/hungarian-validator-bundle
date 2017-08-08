<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\FullName;
use SPE\HungarianValidatorBundle\Validator\FullNameValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class FullNameValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new FullNameValidator();
    }

    /**
     * @dataProvider provideInvalidFullNames
     */
    public function testInvalidFullNames($value)
    {
        $this->validator->validate($value, new FullName());
        $this->buildViolation("Please enter your full name")
            ->assertRaised();
    }

    public function provideInvalidFullNames()
    {
        return [
            ['Péter '],
        ];
    }

    /**
     * @dataProvider provideValidFullNames
     */
    public function testValidFullNames($value)
    {
        $this->validator->validate($value, new FullName());
        $this->assertNoViolation();
    }

    public function provideValidFullNames()
    {
        return [
            ['Kiss Pippin'],
            ['KissőŰú Píppinß'],
            ['Kiss nagy Pippin'],
            ['Kiss-nagy Pippin'],
            ['Dr. prof. Kiss Pippin'],
            [' Kiss Pippin    '],
        ];
    }
}
