<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\FullName;
use SPE\HungarianValidatorBundle\Validator\FullNameValidator;

use SPE\HungarianValidatorBundle\Tests\Validator\ValidatorTest;

class FullNameValidatorTest extends ValidatorTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->validator = new FullNameValidator();
        $this->validator->initialize($this->context);

        $this->constraint = new FullName(array('message' => $this->message));
    }

    public function testValidFullNameWithTwoParts()
    {
        $this->shouldBeValid('Kiss Pippin');
    }

    public function testValidFullNameWithLocalizedChars()
    {
        $this->shouldBeValid('KissőŰú Píppinß');
    }

    public function testValidFullNameWithMiddleName()
    {
        $this->shouldBeValid('Kiss nagy Pippin');
    }

    public function testValidFullNameWithDash()
    {
        $this->shouldBeValid('Kiss-nagy Pippin');
    }

    public function testValidFullNameWithDot()
    {
        $this->shouldBeValid('Dr. prof. Kiss Pippin');
    }

    public function testValidFullNameWithWhiteSpaces()
    {
        $this->shouldBeValid(' Kiss Pippin    ');
    }

    public function testNotTheFullName()
    {
        $this->shouldNotBeValid('Péter ');
    }
}
